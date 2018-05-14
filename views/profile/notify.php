<?php 
use yii\helpers\Html;
foreach($arr as $like): ?>
    <?php if($like->user->id != Yii::$app->user->identity->id): ?>
<?= Html::a(Html::img(Yii::getAlias('@web') . '/uploads/' . $like->photo->photo, ['width' => '100px']), ['/profile/view/' . $like->photo->id]) ?>  
оценил(-а) вашу фотографию: <strong><?= Html::a(Html::encode($like->user->login), ['/' . $like->user->id]) ?></strong> <?= Html::img(Yii::getAlias('@web') . '/uploads/' . $like->user->avatar, ['class' => 'avatar-notify']) ?>

<hr>
<?php endif; ?>
    <?php endforeach; ?>

