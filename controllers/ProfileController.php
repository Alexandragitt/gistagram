<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\Comment;
use app\models\CommentForm;
use app\models\Like;
use app\models\Photo;
use app\models\Relation;
use app\models\UploadForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Description of ProfileController
 *
 * @author user
 */
class ProfileController extends Controller {
  
    public function behaviors()
    {
    return [
        'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ],
    ];
}

    public function actionIndex($id = null) {
            if(Yii::$app->request->post('Subscribe')) { // Если пользователь нажал кнопку подписки
            if(Relation::subscribe($id)) { // из модели Relation вызываем статический метод subscribe
                
             return $this->refresh(); 
         }
         }
         if(Yii::$app->request->post('Block')) {
             if(Relation::block($id)) { // из модели Relation вызываем статический метод block
             if(!empty(Relation::findSubscribe($id))) Relation::unsubscribe($id);
             return $this->refresh(); 
         }
         }
         if(Yii::$app->request->post('Unblock')) {
             if(Relation::unblock(Yii::$app->request->post('Unblock'))) { // из модели Relation вызываем статический метод unblock
             return $this->refresh(); 
         }
         }
          if(Yii::$app->request->post('Unsubscribe')) { // Если пользователь нажал кнопку отписки
          if(Relation::unsubscribe(Yii::$app->request->post('Unsubscribe'))) {
          return $this->refresh();
          }
         }
         if(Yii::$app->request->post('Deletephoto') && Photo::findOne(Yii::$app->request->post('Deletephoto'))->user_id == Yii::$app->user->identity->id) {
             if(Photo::deletePhoto(Yii::$app->request->post('Deletephoto'))) {
             return $this->refresh();
             }
         }
         
        $relation_likes = Relation::find()->where(['first_id' => Yii::$app->user->identity->id])->all();
        $vid = empty($id) ? Yii::$app->user->identity->id : $id;
        if (empty(User::findOne($vid))) {
            throw new NotFoundHttpException('Пользователь не найден');
        }
        else {
           $user = User::findOne($vid);
           $relations = Relation::find()->where(['first_id' => $vid, 'type' => 1])->all();
        }
        $photos = Photo::find()->where(['user_id' => $vid])->orderBy(['id' => SORT_DESC])->all();
        $usersubscribed = Relation::find()->where(['second_id' => $vid, 'type' => 1])->all(); // подписанные на пользователя
        $isblacklisted = Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'second_id' => $id, 'type' => 2])->one(); // ЧС от моего аккаунта
        $isblacklisteduser = Relation::find()->where(['first_id' => $id, 'second_id' => Yii::$app->user->identity->id, 'type' => 2])->one(); // ЧС от человека, какого кинули в чс
        $myrelation = Relation::find()->where(['first_id' => Yii::$app->user->identity->id, 'second_id' => $id, 'type' => 1])->all();
        $blocked = Relation::isBlockedByMe();
        if(!empty($isblacklisteduser)) throw new HttpException(403, 'Вы в чёрном списке у ' . $user->login);
        // $myrelation - моё отношение к пользователю, чтобы понимать, подписаться или отписаться
        return $this->render('index', compact('photos', 'user', 'relations', 'myrelation', 'usersubscribed', 'relation_likes', 'isblacklisted', 'blocked'));
    }
    
     public function actionAdd() {
        $model = new UploadForm();
        $photo = new Photo;
        
        $file = UploadedFile::getInstance($model, 'image');
        if(Yii::$app->request->isPost && $model->upload($file) && $photo->load(Yii::$app->request->post())) {
            $value = $model->generateName($file);
            $photo->photo = $value;
            $photo->user_id = Yii::$app->user->identity->id;
            if($photo->save()) {
                Yii::$app->session->setFlash('uploaded');
                return $this->goHome();
            }
        }
        return $this->renderAjax('add', compact('model', 'photo'));
     } 
     
     public function actionAddAvatar() {
         $model = new UploadForm();
         $file = UploadedFile::getInstance($model, 'image');
         $user = User::findOne(Yii::$app->user->identity->id);
         if(Yii::$app->request->isPost && $model->upload($file)) {
             $value = $model->generateName($file);
             $user->avatar = $value;
             $user->save();
             
             return $this->goHome();
         }
         return $this->renderAjax('add-avatar', compact('model', 'user'));
     }
     
     public function actionView($id = null) {
         if(!empty($id)) {
             $photo = Photo::findOne($id);
         }
         else {
             return $this->redirect("/");
         }
         $find = Comment::findOne(Yii::$app->request->post('DeleteComment'));
         if(Yii::$app->request->post('DeleteComment') && ($find->user_id == Yii::$app->user->identity->id || $find->photo->user_id == Yii::$app->user->identity->id)) { // если нажали "Удалить коммент", и проверяем, что id именно тот, который послали, чтобы не был удален чужой коммент из-за невнимательности
             if(Comment::deleteComment(Yii::$app->request->post('DeleteComment'))){
                return $this->refresh();
             }
         }
         
         $photo->addViews($id); // добавляем просмотр к изображению
         $likes = Like::find()->where(['photo_id' => $id])->all();
         $mylike = Like::find()->where(['photo_id' => $id, 'user_id' => Yii::$app->user->identity->id])->one();
         $comments = Comment::find()->where(['photo_id' => $id])->all();
         $model = new CommentForm;
         $model->user_id = Yii::$app->user->identity->id;
         $model->photo_id = $id;
         if($model->load(Yii::$app->request->post()) && $model->saveComment()) {
             Yii::$app->session->setFlash('commented');
             if(Yii::$app->user->identity->id != $photo->user->id) $photo->views--; // ибо добавляется лишний просмотр при рефреше после написания коммента
             $photo->save();
             return $this->refresh();
         }
        $isblacklisteduser = Relation::find()->where(['first_id' => $photo->user->id, 'second_id' => Yii::$app->user->identity->id, 'type' => 2])->one(); // ЧС от человека, какого кинули в чс
        if(!empty($isblacklisteduser)) throw new HttpException(403, "Вы в чёрном списке у автора этой фотографии");
        if(!$photo) throw new NotFoundHttpException('Такой фотографии не существует');
        return $this->render('view', compact('photo', 'model', 'comments', 'likes', 'mylike'));
     }

     public function actionEdit() {
         $user = User::findOne(Yii::$app->user->identity->id);
         $model = new \app\models\EditForm();
         if($model->load(Yii::$app->request->post()) && $model->change()) {
             Yii::$app->session->setFlash('datachanged');
             return $this->refresh();
         }
         
         return $this->render('edit', compact('model', 'user'));
     }
     
     public function actionLike() {
         $photo = Photo::findOne(Yii::$app->request->post()); // Находим фотку с этим ID (а то передадут через бурп какой то левый айдишник еще..)
         if($photo) Like::like(Yii::$app->request->post('id')); // и если фотка найдена, то лайкаем. Принимаем post ID фотки из AJAX (main.js)
         }
     
     public function actionUnlike() {
        $photo = Photo::findOne(Yii::$app->request->post('id')); // Находим фотку с этим ID (а то передадут через бурп какой то левый айдишник еще..)
        if($photo) Like::unlike(Yii::$app->request->post('id')); // принимает post ID фотки из AJAX (main.js)
     }
    
     public function actionLiked() {
         $relations = Relation::find()->where(['first_id' => Yii::$app->user->identity->id])->all();
         if(empty($relations[0]->likes)) throw new HttpException(403,'У вас нет понравившихся фотографий');
         return $this->render('liked', compact('relations'));
     }
     
     public function actionBlocked() {
         $blocked = Relation::isBlockedByMe();
         if(!$blocked) throw new HttpException(403, 'У вас нет заблокированных пользователей');
          if(Yii::$app->request->post('Unblock')) {
             if(Relation::unblock(Yii::$app->request->post('Unblock'))) { // из модели Relation вызываем статический метод unblock
             return $this->refresh(); 
         }
          }
         return $this->render('blocked', compact('blocked'));
     }
     
     public function actionNotify() {
         $photos = Photo::getMyPhotos();
         $arr = [];
         foreach($photos as $photo) {
             foreach($photo->likes as  $like) {
                 array_push($arr, $like);
             }
         }
         rsort($arr);
         return $this->renderAjax('notify', compact('arr'));
     }
     
    public function actionSubscribers($id) {
    $subscribers = Relation::subscribers($id);
    if(Yii::$app->request->isAjax) { 
        return $this->renderAjax('subscribers', compact('subscribers'));
    }
    else {
        return $this->redirect(['/' . $id]); // если мы не в модальном окне, а перешли по ссылке, то редирект на стр
    }
    }
    public function actionFollows($id) {
    $subscribers = Relation::follows($id);
    if(Yii::$app->request->isAjax) { 
        return $this->renderAjax('follows', compact('subscribers'));
    }
    else {
        return $this->redirect(['/' . $id]); // если мы не в модальном окне, а перешли по ссылке, то редирект на стр
    }
} 
   
       
}

