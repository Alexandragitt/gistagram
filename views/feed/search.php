<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<center>
    
    <?php foreach($users as $user): ?>
        <?php if($user->id != Yii::$app->user->identity->id): ?>
        <div class="panel panel-default table-responsive my-panel">
        <div class="panel-heading">
            <?= Html::img(Yii::getAlias('@web') . '/uploads/' . $user->avatar, ['class' => 'avatar-feed']) ?>&nbsp;&nbsp;<strong><?= Html::a(Html::encode($user->login), ['/' . $user->id])?></strong>
            <?php if($user->verified == 1): ?>
            <?= Html::img(Yii::getAlias('@web') . '/images/checkmark.png', ['width' => '15px', 'title' => 'Подтвержденная страница']) ?>
            <?php endif; ?>
            <hr><?= Html::encode($user->bio)?></div>
  <div class="panel-body"><?php foreach($user->photos as $key => $photos): ?>
        <?php if($key <= 5): // 6 фоток только достанем для одного результата поиска (с нуля ж) ?>
        <?= Html::img(Yii::getAlias("@web") . '/uploads/' . $photos->photo, ['class' => 'min-photo-search']) ?>
        <?php endif; ?>
            <?php endforeach; ?>
  </div>
</div>
    <?php endif; ?>
    <?php endforeach; ?>
    
</center>
