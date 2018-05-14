<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<?= "<h1>Ваша лента</h1><br>" ?>
<?php foreach($photos as $photo): ?>

<?= \yii\helpers\Html::img(Yii::getAlias("@web") . '/uploads/' . $photo->photo, ['class' => 'imgmax']) ?>

<?php endforeach; ?>
