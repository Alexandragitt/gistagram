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
 * Description of Like
 *
 * @author user
 */
class Like extends ActiveRecord {
    public static function tableName() {
        return 'likes';
    }
    
    public function getPhoto() {
        return $this->hasOne(Photo::className(), ['id' => 'photo_id']);
    }
    
    public static function like($id) {
        $like = new Like();
        /* проверка, если этот пользователь лайк уже ставил,
         * чтобы лайк не повторялся больше и в базу не записывался тот же лайк повторно  */
        $getlike = Like::find()->where(['photo_id' => $id, 'user_id' => Yii::$app->user->identity->id])->all();
        if(empty($getlike)) {
        $like->user_id = Yii::$app->user->identity->id;
        $like->photo_id = $id;
        return $like->save();
        }
    }
    public static function unlike($id) {
        $like = Like::find()->where(['user_id' => Yii::$app->user->identity->id, 'photo_id' => $id])->one();
        return $like->delete();
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
