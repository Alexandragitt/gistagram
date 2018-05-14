<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\base\Model;

/**
 * Description of CommentForm
 *
 * @author user
 */
class CommentForm extends Model {
    public $comment;
    public $user_id;
    public $photo_id;
    public $date;
    
    public function rules() {
        return [
            [['user_id', 'photo_id', 'date'], 'safe'],
            ['comment', 'required', 'message' => 'Введите текст комментария'],
            ['comment', 'trim'],
        ];
    }
    
    public function saveComment() {
        $com = new Comment;
        $com->comment = $this->comment;
        $com->user_id = $this->user_id;
        $com->photo_id = $this->photo_id;
        return $com->save();
    }
    
}
