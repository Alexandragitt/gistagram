<?php
use yii\helpers\Html;
$this->title = "Понравившиеся публикации";
?>
<div class="row">
    <?php foreach($relations[0]->likes as $like): ?>
<center>
        <div class = 'col-md-4'>
            <figure>
        <div class = 'thumbnail'><?= Html::a(Html::img(Yii::getAlias("@web") . '/uploads/' . $like->photo->photo, ['width' => '150px']), ['profile/view/' . $like->photo->id]) ?>
        </div>
       <figcaption><?= Html::button(Html::img(Yii::getAlias("@web") . '/images/like-active.png', ['width' => '25px', 'class' => 'unlike-btn-feed', 'data-id' => $like->photo->id]), ['class' => 'floating-unlike-feed', 'name' => 'like', 'data-id' => $like->photo->id]) ?>
       </figcaption><hr><br><br>
                
            </figure>
           
        </div>
 
</center>
    
        <?php endforeach; ?>
</div>
