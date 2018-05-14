<?php

use yii\helpers\Html;

$this->title = 'Лента';
$imgsdir = Yii::getAlias('@web') . '/images/';
?>

<?php if(!empty($recommend)): ?>
<center><h4>Возможно, Вам будут интересны следующие аккаунты:</h4></center>
<center>
<?php foreach ($recommend as $user): ?>
<?php if($user->id != Yii::$app->user->identity->id): ?>
        <div class ='col-md-4'>
        <div class="panel panel-default table-responsive my-panel-profile">
        <div class="panel-heading">
            <?= Html::img(Yii::getAlias('@web') . '/uploads/' . $user->avatar, ['class' => 'avatar-feed']) ?>&nbsp;&nbsp;<strong><?= Html::a(Html::encode($user->login), ['/' . $user->id])?></strong>
            <?php if($user->verified == 1): ?>
            <?= Html::img(Yii::getAlias('@web') . '/images/checkmark.png', ['width' => '15px', 'title' => 'Подтвержденная страница']) ?>
            <?php endif; ?>
            </div>
</div>
        </div>
    <?php endif; ?>
    </center>
<?php endforeach; ?>
<?php endif; ?>

<hr>

<?php
foreach($arr as $array): ?>

<?php 
$location = (!empty($array->location)) ? $array->location : null;
?>

<center>
        <div class="panel panel-default table-responsive my-panel">
        <div class="panel-heading"><?= Html::img(Yii::getAlias('@web') . '/uploads/' . $array->user->avatar, ['class' => 'avatar-feed']) ?>&nbsp;&nbsp;<strong><?= Html::a(Html::encode($array->user->login), ['/' . $array->user->id]) ?></strong>
            <hr>
             <?php if($location): ?>
            <strong><?= Html::img(Yii::getAlias('@web' . '/images/location.png'), ['title' => 'Местоположение']) . '&nbsp;' . Html::encode($location)  ?></strong> <br>
      <?php endif; ?>
         <?= Html::img($imgsdir . 'eye.png', ['title' => 'Количество просмотров', 'width' => '20px']); ?> <?= $array->views ?>&nbsp;
         <?= Html::img($imgsdir . 'comments.png', ['title' => 'Комментарии', 'width' => '15px']); ?> <?= $array->getComments()->count() ?>&nbsp;
          <?php if($array->checkIfLiked($array->id)): ?>
           <?= Html::img($imgsdir . 'like-active.png', ['title' => 'Вы оценили публикацию ' . $array->user->login, 'width' => '15px']); ?> <?= $array->getLikes()->count() ?>&nbsp;
         <?php else: ?>
            <?= Html::button(Html::img(Yii::getAlias("@web") . '/images/like-unactive.png', ['width' => '20px', 'class' => 'like-btn-feed', 'data-id' => $array->id]), ['class' => 'floating-like-feed', 'name' => 'like', 'data-id' => $array->id]) ?>
         <?= Html::img($imgsdir . 'like-unactive.png', ['title' => 'Количество людей, каким понравилась публикация', 'width' => '15px']); ?> <?= $array->getLikes()->count() ?>&nbsp;
          
               <?php endif; ?>
        
         
        </div>
           
            <div class="panel-body"><?= Html::a(Html::img(Yii::getAlias('@web') . '/uploads/' . $array->photo, ['class' => 'imgmax-feed']), ['profile/view/' . $array->id], ['data-id' => $array->id]) ?></div>
 
  <div class="panel-footer">
          <?php if(!empty($array->description)): ?>
      <?= Html::encode($array->description) ?>
  </div>

  <?php endif; ?>
</div>
</center>
    <?php endforeach; ?>





    
