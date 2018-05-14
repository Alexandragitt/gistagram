<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Description of AuthController
 *
 * @author user
 */
class AuthController extends Controller {

    public $layout = false;

    public function behaviors() {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['login', 'register'],
              'rules' => [
                  [
                      'allow' => true,
                      'roles' => ['?'],
                  ]
              ]
          ]
        ];
        }
    
    public function actionLogin() {
    $model = new LoginForm;
    if ($model->load(Yii::$app->request->post()) && $model->enter()) {
        return $this->redirect(['feed/index']);
    }
        return $this->render('login', compact('model'));
    }
    
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->redirect(['auth/login']);
    }
    
    public function actionRegister() {
        $model = new RegisterForm;
        if(Yii::$app->request->isPost) {
            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->register()) {
                return $this->redirect(Url::to(['auth/login']));
            }
        }
        
        return $this->render('register', compact('model'));
        
    }
}
