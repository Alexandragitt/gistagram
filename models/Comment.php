<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Description of Comments
 *
 * @author user
 */
class Comment extends ActiveRecord {

    public static function tableName() {
        return 'comments';
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getPhoto() {
        return $this->hasOne(Photo::className(), ['id' => 'photo_id']);
    }
    public static function deleteComment($id) { // метод для удаления коммента (КЭП)
        $comment = Comment::findOne($id);
        return $comment->delete();
    }
    
}
