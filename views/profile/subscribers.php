<?php

use yii\helpers\Html;
foreach($subscribers as $subscribe): ?>
<?php foreach($subscribe->usersubscribed as $subscribed):  ?>
<h4><?= Html::img(Yii::getAlias("@web") . '/uploads/' . $subscribed->avatar, ['class' => 'avatar-feed']) . '&nbsp;'. Html::a(Html::encode($subscribed->login), ['/' . $subscribed->id]) ?></h4>
    <hr><?php endforeach; ?>
<?php endforeach; ?>

