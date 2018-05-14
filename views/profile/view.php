<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '@' . Html::encode($photo->user->login);
?>
<center>
    <?= Html::img(Yii::getAlias("@web") . '/uploads/' . $photo->user->avatar, ['class' => 'avatar-photo']) ?>
    <h4><?= Html::a(Html::encode($photo->user->login), ['/' . $photo->user->id]) ?></h4>
    <?= Html::img(Yii::getAlias("@web") . '/images/clock.png', ['width' => '17px', 'title' => 'Когда загружена публикация']) ?> <?= Yii::$app->formatter->asDate($photo->date, 'long') ?>
    <hr>
<?php if(Yii::$app->session->hasFlash('commented')): ?>
    <?= \yii\bootstrap\Alert::widget([
    'options' => [
        'class' => 'alert alert-success',
    ],
    'body' => "Ваш комментарий успешно добавлен!"
    ]);
        ?>
    <?php endif; ?>
        <div class="panel panel-default table-responsive panel-full">
        <?php if(!empty($photo->location)): ?>
            <div class="panel-heading">
                <strong><?= Html::img(Yii::getAlias("@web") . '/images/location.png')?> <?= Html::encode($photo->location) ?></strong>
            </div>
        <?php endif; ?>
            <div class="panel-body">
                
                <?php if(!empty($mylike)): ?>
                <?= Html::button(Html::img(Yii::getAlias("@web") . '/images/like-active.png', ['width' => '17px', 'class' => 'unlike-btn', 'data-id' => $photo->id]), ['class' => 'floating-unlike', 'name' => 'unlike']) ?>
                <?= "<p class = 'like-count-liked'>" . count($likes) . "</p>" ?>
                    <?php else: ?>
                <?= Html::button(Html::img(Yii::getAlias("@web") . '/images/like-unactive.png', ['width' => '17px', 'class' => 'like-btn', 'data-id' => $photo->id]), ['class' => 'floating-like', 'name' => 'like']) ?>
                <?= "<p class = 'like-count-notliked'>" . count($likes) . "</p>" ?>
                    <?php endif; ?>
                
                <?=  Html::a(Html::img(Yii::getAlias('@web') . '/uploads/' . $photo->photo, ['class' => 'img-full']), ['profile/view', 'id' => $photo->id]) ?></div>
    <?php if(!empty($photo->description)): ?>
  <div class="panel-footer">
    <?= Html::encode($photo->description) ?>
  </div>
  <?php endif; ?>

</div>
      <?php if(!empty($comments)): ?>
    <hr>
    <?php foreach($comments as $comment): ?>
    <div class="panel panel-default table-responsive panel-full">
        <div class="panel-heading"><?php if(!empty($comment->user->avatar)) : ?>
            <?= Html::img(Yii::getAlias('@web') . '/uploads/' . $comment->user->avatar, ['class' => 'avatar-feed']) ?><?php endif;?>
            <strong>&nbsp;<?= Html::a(Html::encode($comment->user->login), ['/' . $comment->user->id])?></strong></div>
    
        <div class="panel-body"><?= Html::encode($comment->comment) ?> 
    <?php if(Yii::$app->user->identity->id == $photo->user->id || Yii::$app->user->identity->id == $comment->user->id): ?>
        <?php ActiveForm::begin(); ?>
        <?= Html::submitButton('Удалить', ['name' => 'DeleteComment', 'value' => $comment->id, 'class' => 'btn btn-link']) ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    </div>
       </div>
    <?php endforeach; ?>
    <?php else: ?>
    <hr>
    <h4>Будьте первыми, кто прокомментирует эту публикацию <strong>@<?= Html::encode($photo->user->login) ?></strong></h4>
  <?php endif; ?>
     <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'comment')->textarea(['rows' => '4', 'cols' => '4', 'placeholder' => 'Введите текст комментария'])->label(false) ?>
    <?= Html::submitButton('Комментировать', ['class' => 'btn btn-default']) ?>
    <?php ActiveForm::end(); ?>
</center>

