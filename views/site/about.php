<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); 
?>
  <?= $form->field($model, 'image')->fileInput()->label(false); ?>
<?= Html::submitButton('Отправить', ['class' => 'btn btn-success']); ?>
<?php ActiveForm::begin(); ?>
