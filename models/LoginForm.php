<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $login;
    public $password;
    
    
    public function rules() {
        return [
            [['login', 'password'], 'required'],
            ['login', 'string', 'length' => [5, 20]],
            ['password', 'string', 'length' => [6, 20]],
            ['password', 'trim'],
            ['login', 'trim'],
        ];
    }
    public function attributeLabels() {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
        }
    public function getUser() {
        return User::findByLogin($this->login); 
    }
    public function validatePass() {
       $user = $this->getUser();
       if(!$user || !$user->validatePassword($this->password)) {
           $this->addError('None');
       }
       else return true;
    }
    public function enter() {
        if($this->validatePass()) {
            return Yii::$app->user->login($this->getUser(), time() + 7 * 24 * 60 * 60);
        }
        return false;
    }
}
