<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PlaceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$area = 'place';
$this->title = Yii::t('app/backend', 'Places');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Helper::createButton( $area ); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'photo',
                'value' => function( $model ) {
                    /** @var \common\models\Place $model */
                    return $model->getImagePath([ 'width' => 200 ]);
                },
                'format' => 'image',
                'enableSorting' => false,
                'filter' => false
            ],
            'name',
            'address',
            [
                'attribute' => 'phone',
                'value' => function( $model ) {
                    /** @var \common\models\Place $model */
                    return $model->maskedPhone;
                }
            ],
            'is_default:boolean',
            'is_blocked:boolean',
            //'created_at',
            //'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ]
        ]
    ]); ?>
    <?php // todo - add paid column!!! ?>
    <?php // todo - add members column!!! ?>
    <?php // todo - add party column!!! ?>
    <?php Pjax::end(); ?>
</div>
