<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Description of EditForm
 *
 * @author user
 */
class EditForm extends Model {
    public $firstname;
    public $login;
    public $bio;
    public $user;
    public $oldPassword;
    public $newPassword;
    public $repeatNewPassword;
public function __construct($config = array()) {
    parent::__construct($config);
    $user = User::findOne(Yii::$app->user->identity->id);
    $this->firstname = $user->firstname;
    $this->bio = $user->bio;
    
}
    public function rules() {
        return [
            [['bio','firstname', 'oldPassword', 'newPassword', 'repeatNewPassword'], 'trim'],
            [['oldPassword'], 'validatePassword'],
            [['newPassword'], 'string', 'min' => 6],
            ['repeatNewPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли должны совпадать'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'firstname' => 'Имя',
            'bio' => 'О себе',
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'repeatNewPassword' => 'Подтвердите новый пароль',
        ];
    }
    public function validatePassword()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->oldPassword)) {
            $this->addError('oldPassword', 'Неправильно введён нынешний пароль');
        }
    }
    
   
    public function change()
    {
        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->firstname = $this->firstname;
            $user->bio = $this->bio;
            if(!empty($this->oldPassword)) {
            $user->setPassword($this->newPassword);
            }
            if ($user->save()) {
                return true;
            }
        }
        return false;
    
}
}
