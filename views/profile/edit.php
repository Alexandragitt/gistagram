<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Alert;
use yii\helpers\Html;
$this->title = 'Редактирование профиля';
if(Yii::$app->session->hasFlash('datachanged')): ?>

<?= Alert::widget([
    'options' => [
        'class' => 'alert alert-info',
        ],
    'body' => 'Данные были успешно изменены'
]); ?>
<?php endif; ?>

<?php $form = ActiveForm::begin(); ?>
<center>
<?= Html::img(Yii::getAlias('@web') . '/uploads/' . $user->avatar, ['class' => 'avatar-profile']) ?>
    <br>
<?= Html::button("Изменить аватарку", ['class' => 'btn btn-link change-avatar']) ?>
</center>
<?= $form->field($model, 'firstname') ?>
<?= $form->field($model, 'bio') ?>
 <?= $form->field($model, 'oldPassword')->passwordInput() ?>
 <?= $form->field($model, 'newPassword')->passwordInput() ?>
 <?= $form->field($model, 'repeatNewPassword')->passwordInput() ?>
<?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs(
  "$(document).on('ready', function() {  
    $('.change-avatar').click(function(e){
    e.preventDefault();
       $('#pModal').modal('show')
                  .find('.content')
                  .load('/profile/add-avatar');  
   });
});
");

 yii\bootstrap\Modal::begin([
    'header' => 'Загрузить аватарку',
    'id'=>'pModal',
]);
echo '<div class = "content"></div>';
 yii\bootstrap\Modal::end();
 ?>