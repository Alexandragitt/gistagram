<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Заблокированные';
foreach($blocked as $block): ?>
<div class="panel panel-default table-responsive my-panel">
    
        <div class="panel-heading">
            <?= Html::img(Yii::getAlias('@web') . '/uploads/' . $block->user->avatar, ['class' => 'avatar-feed']) ?>&nbsp;&nbsp;<strong><?= Html::a(Html::encode($block->user->login), ['/' . $block->user->id]) ?></strong>
           <?php ActiveForm::begin(); ?>
           <?= Html::submitButton('Разблокировать', ['title' => "Разблокировать", 'name' => 'Unblock', 'value' => $block->user->id, 'class' => 'btn btn-default unblock']) ?>
            <?php ActiveForm::end(); ?>
        </div>
</div>


<?php endforeach; ?>


