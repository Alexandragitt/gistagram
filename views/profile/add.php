<?php

use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
/* @var $this View */
/* @var $model app\models\Article */
/* @var $form ActiveForm */
$this->title = 'Загрузка фотографии';
?>

<div class="article-form">
    <?php if(Yii::$app->session->hasFlash('uploaded')): ?>
    <?= '<p class = "alert alert-info">Фото было успешно загружено в Ваш ' . Html::a("<strong>профиль</strong></p>", Url::to(['/' . Yii::$app->user->identity->id])); ?>
    <?php endif; ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'image')->fileInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($photo, 'description')->textarea() ?>
    <?= $form->field($photo, 'location')->textInput() ?>
    
    <div class="form-group">
        <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

