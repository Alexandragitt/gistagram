<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\base\Model;

/**
 * Description of RegisterForm
 *
 * @author user
 */
class RegisterForm extends Model {
    public $login;
    public $password;
    public $bio;
    public $firstname;
    public function attributeLabels() {
       return [
           'login' => 'Логин',
           'password' => 'Пароль',
           'firstname' => 'Имя',
           'bio' => 'О себе',
           'verified' => 'Подтвержденная страница',
       ];
       }
       
       
   public function rules() {
        return [
            [['login', 'password'], 'required', 'message' => 'Это обязательное поле'],
            ['login', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот логин уже занят, выберите другой'],
            ['login', 'string', 'length' => [5, 20]],
            ['password', 'string', 'length' => [6, 20]],
            [['password', 'bio', 'firstname', 'login'], 'trim'],
            ['bio', 'string', 'length' => [5, 100]],
            ['firstname', 'string', 'length' => [3, 20]],
        ];
    }
    
    public function register() {
        $user = new User();
        $user->login = $this->login;
        $user->setPassword($this->password);
        $user->bio = $this->bio;
        $user->firstname = $this->firstname;
        return $user->save();
    }
}
