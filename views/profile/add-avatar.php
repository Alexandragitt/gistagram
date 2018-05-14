<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Загрузка аватарки';

$form = ActiveForm::begin(['enableAjaxValidation' => false, 'enableClientValidation' => true, 'id' => 'someform']); 
?>
<center><?= Html::img(Yii::getAlias("@web") . '/uploads/' . $user->avatar, ['class' => 'avatar-profile']) ?><hr>
<?= $form->field($model, 'image')->fileInput()->label(false) ?> 

<?= Html::submitButton('Обновить', ['class' => 'btn btn-success']) ?>
</center>
<?php ActiveForm::end(); ?>
