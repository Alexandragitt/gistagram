<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use app\models\User;
use Yii;
use yii\db\ActiveRecord;
/**
 * Description of Photo
 *
 * @author user
 */
class Photo extends ActiveRecord {
    
    public static function tableName() {
        return 'photos';
    }
    
    public function rules() {
        return [
            [['description', 'location', 'photo'], 'trim'],
            
        ];
    }
    
    public function attributeLabels() {
        return [
            'description' => "Описание",
            'location' => 'Местоположение',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public function addViews($id) {
        $photo = Photo::findOne($id);
        if(Yii::$app->user->identity->id != $photo->user->id) $photo->views++;
        return $photo->save();
    }
    public function getComments() {
        return $this->hasMany(Comment::className(), ['photo_id' => 'id']);
    }
    public static function getMyPhotos() {
        return Photo::find()->where(['user_id' => Yii::$app->user->identity->id])->orderBy(['date' => SORT_DESC])->all();
    }
    public function getLikes() {
        return $this->hasMany(Like::className(), ['photo_id' => 'id'])->orderBy(['date' => SORT_DESC]);
    }
     public function getRelations() {
        return $this->hasOne(Relation::className(), ['second_id' => 'user_id']);
    }
    public function checkIfLiked($id) {
        return Like::find()->where(['user_id' => Yii::$app->user->identity->id, 'photo_id' => $id])->all();
    }
    public static function deletePhoto($id) {
             return Photo::findOne($id)->delete();
    }
}
