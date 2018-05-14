<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Gistagram',
        'brandUrl' => ['/'],
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    if(Yii::$app->user->identity) {
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
           Yii::$app->user->identity->admin ? (['label' => 'Администрирование', 'url' => ['/admin/']]) : '' ,
            !Yii::$app->user->isGuest ? (['label' => 'Лента', 'url' => ['/feed/index']]) : '',
            !Yii::$app->user->isGuest ? (
                    ['label' => 'Профиль', 'url' => ['/' . Yii::$app->user->identity->id]]) : '',
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/auth/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/auth/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->login . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
}
    ?>
    <div class="form-group row">
 <?= !Yii::$app->user->isGuest ? Html::img(Yii::getAlias('@web') . '/images/bell-unactive.png', ['class' => 'bell-unactive']) : '' ?>         

  <div class="col-md-3">
      <form method = "get" action = "<?= Url::to(['feed/search']) ?>">
    <input class="form-control" name = 'q' type="search" placeholder="Поиск пользователя" id="example-search-input">
      </form>
  </div>
   </div>
    <?php
    NavBar::end();
    ?>
   
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?php
$this->registerJs(
  "$(document).on('ready', function() {  
    $('.bell-unactive').click(function(e){
       $('#pModal').modal('show')
                  .find('.content')
                  .load('/profile/notify');  
   });
});
");

 yii\bootstrap\Modal::begin([
    'header' => 'Последние понравившиеся',
    'id'=>'pModal',
]);
echo '<div class = "content"></div>';
 yii\bootstrap\Modal::end();
 ?>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::a("Riabova Alexandra", ['/1']) ?> <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
