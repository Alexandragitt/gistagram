<?php

use app\models\PhotoSearch;
use yii\bootstrap\Alert;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel PhotoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Фотографии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="photo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Alert::widget([
    'options' => [
        'class' => 'alert alert-danger',
    ],
    'body' => "<p>Возможность добавления фотографий отключена.</p>"
]);
        ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'photo',
            'description',
            'location',
            // 'date',
            // 'views',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
