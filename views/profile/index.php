<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;

$this->title = $user->firstname . " (@$user->login)";
$imgsdir = Yii::getAlias('@web') . '/images/';
?>
<?php if(!empty($isblacklisteduser)):  ?>
<?= 'blocked' ?>
<?php endif; ?>
<?php if(!($user->login == Yii::$app->user->identity->login)):?>
<center>
    <?php ActiveForm::begin(); ?>
    <?php if(!empty($isblacklisted)): ?>
    <?= Html::submitButton(Html::img(Yii::getAlias('@web') . '/images/unblock.png', ['width' => '18px']), ['title' => "Разблокировать", 'name' => 'Unblock', 'value' => $user->id, 'class' => 'btn btn-default unblock']) ?>
    <?php else: ?>
    <?= Html::submitButton(Html::img(Yii::getAlias('@web') . '/images/blacklist.png', ['width' => '18px']), ['title' => 'Заблокировать', 'name' => 'Block', 'value' => $user->id, 'class' => 'btn btn-default block']) ?>
    <?php endif; ?>
        <?php if(empty($myrelation)): ?> 
    <?= Html::submitButton('Подписаться', ['name' => 'Subscribe', 'value' => $user->id, 'class' => 'btn btn-default']) ?>
    <?php else: ?>
    <?= Html::submitButton('Отписаться', ['name' => 'Unsubscribe', 'value' => $user->id, 'class' => 'btn btn-default']) ?>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>
</center>
<br>
 <?php endif; ?>
<?php if(!empty($user->avatar)): ?>
<center>
<?= Html::img(Yii::getAlias('@web') . '/uploads/' . $user->avatar, ['class' => 'avatar-profile']) ?>
</center>
    <?php endif; ?>

<h2 align = 'center'><?php if($user->verified == 1): ?>
    <?= Html::img(Yii::getAlias('@web') . '/images/checkmark.png', ['width' => '25px', 'title' => 'Подтвержденная страница']) ?>
<?php endif; ?> <?= Html::encode($this->title) ?></h2>
<h4 align = 'center'><?= Html::encode($user->bio) ?></h4>
<center>
<?php if(($user->login == Yii::$app->user->identity->login)): ?>
    <?= Html::a('Редактировать профиль', ['profile/edit'], ['class' => 'btn btn-default']) ?>
    <?php if(!empty($relation_likes[0]->likes)): // кнопка будет показывать только тем, у кого есть хоть одна лайкнутая публикация?>
    <?= Html::a(Html::img(Yii::getAlias('@web') . '/images/like-active.png', ['width' => '18px', 'title' => 'Понравившиеся публикации']), ['profile/liked'], ['class' => 'btn btn-default']) ?>
    <?php endif; ?>
    <?= Html::button(Html::img(Yii::getAlias('@web') . '/images/camera.png', ['width' => '18px', 'title' => 'Добавить фото']), ['class' => 'btn btn-default add-photo']) ?>
    <?php if(!empty($blocked)): ?>
    <?= Html::a(Html::img(Yii::getAlias('@web') . '/images/blocked.png', ['width' => '18px', 'title' => 'Заблокированные пользователи']), ['profile/blocked'], ['class' => 'btn btn-default']) ?>
    <?php endif; ?>
    <br><br>
<?php endif; ?>
    
</center>

<p align = 'center'>Фото: <strong><?= Html::encode($user->getPhotos()->count())?></strong>
    &nbsp;&nbsp;&nbsp;&nbsp;Подписки: <strong><?= Html::a(Html::encode(count($relations)), ['/profile/follows?id=' . $user->id], ['class' => 'follows', 'data-id' => $user->id]) ?></strong>
    &nbsp;&nbsp;&nbsp;&nbsp;Подписчики: <strong><?= Html::a(Html::encode(count($usersubscribed)), ['/profile/subscribers?id=' . $user->id], ['class' => 'subscribers', 'data-id' => $user->id]) ?></strong></p>


<hr>
<?php if(count($photos) == 0): ?>

<?= Alert::widget([
    'options' => [
        'class' => 'alert alert-info',
    ],
    'body' => "<h2 align = 'center'>В этом профиле пока что нет фотографий</h2>"
]);
        ?>

<?php else: ?>
<div class="row">
<?php foreach($photos as $key => $photo): ?>
    
<center>
        <div class = 'col-md-4'>
        <div class="panel panel-default table-responsive my-panel-profile">
            <div class="panel-heading">
                <?php if($photo->user_id == Yii::$app->user->identity->id): ?>
                <?php ActiveForm::begin(); ?>
                <?= Html::submitButton(Html::img(Yii::getAlias("@web") . '/images/deletephoto.png', ['width' => '12px', 'value' => $photo->id, 'class' => 'deletephoto-btn', 'data-id' => $photo->id]), ['title' => 'Удалить', 'value' => $photo->id, 'class' => 'floating-deletephoto', 'name' => 'Deletephoto']) ?>
                <?php ActiveForm::end(); ?>
                <?php endif; ?>
                <?= Html::img($imgsdir . 'eye.png', ['title' => 'Просмотры', 'width' => '20px']); ?> <strong><?= $photo->views ?></strong>&nbsp;
                <?= Html::img($imgsdir . 'comments.png', ['title' => 'Комментарии', 'width' => '15px']); ?> <strong><?= $photo->getComments()->count() ?></strong>&nbsp;
                <?= Html::img($imgsdir . 'like-unactive.png', ['title' => 'Понравилось', 'width' => '15px']); ?> <strong><?= $photo->getLikes()->count() ?></strong>
                </div>
            
            </div>
            
            <div class = 'thumbnail'><?=  Html::a(Html::img(Yii::getAlias('@web') . '/uploads/' . $photo->photo, ['class' => 'imgmax-profile']), ['profile/view', 'id' => $photo->id]) ?></div>
            <hr>
        </div>
    
</center>
    
<?php endforeach; ?>
  </div>
<?php endif; ?>
<?php
$this->registerJs(
  "$(document).on('ready', function() {  
    $('.add-photo').click(function(){
       $('#pModal').modal('show')
                  .find('.content')
                  .load('/profile/add');  
   });
   $('.subscribers').click(function(e){
   e.preventDefault();
       $('#pModalSubscribers').modal('show')
                  .find('.content')
                  .load('/profile/subscribers?id=' + $(this).data('id'));  
   });
  $('.follows').click(function(e){
   e.preventDefault();
       $('#pModalFollows').modal('show')
                  .find('.content')
                  .load('/profile/follows?id=' + $(this).data('id'));  
   });
});
");

 yii\bootstrap\Modal::begin([
    'header' => 'Загрузить фотографию',
    'id'=>'pModal',
]);
echo '<div class = "content"></div>';
 yii\bootstrap\Modal::end();
 
 yii\bootstrap\Modal::begin([
    'header' => 'Подписчики',
    'id'=>'pModalSubscribers',
     'size' => 'modal-sm',
]);
echo '<div class = "content"></div>';
 yii\bootstrap\Modal::end();
 
  yii\bootstrap\Modal::begin([
    'header' => 'Подписки',
    'id'=>'pModalFollows',
     'size' => 'modal-sm',
]);
echo '<div class = "content"></div>';
 yii\bootstrap\Modal::end();
 ?>

