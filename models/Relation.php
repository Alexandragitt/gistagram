<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Description of Relation
 *
 * @author user
 */
class Relation extends ActiveRecord{
        public static function tableName() {
            return 'relations';
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'second_id']);
    }
    public function getUserfollows() {
        return $this->hasMany(User::className(), ['id' => 'second_id']);
    }
    public function getUsersubscribed() {
        return $this->hasMany(User::className(), ['id' => 'first_id']);
    }
    public function getPhotos() {
        return $this->hasMany(Photo::className(), ['user_id' => 'second_id'])->orderBy(['date' => SORT_DESC]);
    }
    public function getLikes() {
        return $this->hasMany(Like::className(), ['user_id' => 'first_id'])->orderBy(['id' => SORT_DESC]);
    }
    
    public static function subscribe($id) { // Нажата кнопка подписки
         $relation = new Relation();
         $relation->first_id = Yii::$app->user->identity->id;
         $relation->second_id = $id;
         $relation->type = 1; // тип 1 - подписка
         return $relation->save();
        }
    public static function block($id) {
        if($rel = Relation::find()->where(['first_id' => $id, 'second_id' => Yii::$app->user->identity->id, 'type' => 1])->one()) {
            $rel->delete(); // Уничтожаем связь с обеих сторон, чтоб при чс не были подписаны друг на друга
        }
        $relation = new Relation();
        $relation->first_id = Yii::$app->user->identity->id;
        $relation->second_id = $id;
        $relation->type = 2; // тип 2 - черный список 
        return $relation->save();
    }
    public static function unsubscribe($id) { // Нажата кнопка отписки
       $relation = Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'second_id' => $id, 'type' => 1])->one();
       return $relation->delete(); 
   }
   public static function findSubscribe($id) {
       return Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'second_id' => $id, 'type' => 1])->one();
   }
       public static function unblock($id) { // Нажата кнопка анблока
       $relation = Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'second_id' => $id, 'type' => 2])->one();
       return $relation->delete(); 
   }
   
   
   public static function subscribers($id) {
       return Relation::find()->where(['second_id' => $id, 'type' => 1])->all();
   }
   public static function follows($id) {
       return Relation::find()->where(['first_id' => $id, 'type' => 1])->all();
   }
   
   public static function follow() {
       return Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'type' => 1])->all();
   }
   
   public static function isBlockedByMe() {
    $blocked = Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'type' => 2])->all();
    return $blocked;
   }
   
   public static function getCountMySubscribe() { // количество человек, на кого подписан текущий юзер
       return Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'type' => 1])->count();
   }
}
