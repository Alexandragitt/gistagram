<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\Photo;
use app\models\Relation;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Description of FeedController
 *
 * @author user
 */
class FeedController extends Controller {
       public function behaviors() {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'only' => ['index', 'search'],
              'rules' => [
                  [
                      'allow' => true,
                      'roles' => ['@'],
                  ]
              ]
          ]
        ];
        }
        
    public function actionIndex() {
       $user = Yii::$app->user->identity->id;
       if(Relation::getCountMySubscribe() < 5) { // если количество на кого подписан меньше чем 5, то будем предлагать ему подписаться
           $recommend = User::getRecommendUsers();
       }
       $relations = Relation::find()->where(['first_id' => $user, 'type' => 1])->all();
       $arr = []; // создаем массив для фотографий
       for($i = 0; $i < count($relations); $i++) { // Получаем связи для текущего пользователя
           $photos = Photo::find()->where(['user_id' => $relations[$i]->second_id])->orderBy(['date' => SORT_DESC])->all();
           foreach($photos as $pho) { 
               array_push($arr, $pho); // в цикле проходим каждую фотку и добавляем ее в массив для фоток
           }
       }
       
       rsort($arr); // делаем обратную сортировку, чтобы лента была начиная с последней загруженной фотки 
       
        return $this->render('index', compact('arr', 'recommend'));
    }
    
    public function actionSearch($q) {
        $users = User::find()->where(['like', 'login', $q])->all();
       
        foreach($users as $user){
        $relations = Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'second_id' => $user->id])->all();
        }
         if(Yii::$app->request->post('Subscribe')) { // Если пользователь нажал кнопку подписки
             if(Relation::subscribe(Yii::$app->request->post('Subscribe'))) {
                 return $this->redirect(['/' . Yii::$app->request->post('Subscribe')]);
             }
         }
          if(Yii::$app->request->post('Unsubscribe')) { // Если пользователь нажал кнопку отписки
        if(Relation::unsubscribe(Yii::$app->request->post('Unsubscribe'))) {
            return $this->refresh();
        }
         }
        return $this->render('search', compact('users', 'relations'));
    }
    }

