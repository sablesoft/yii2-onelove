<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Place;
use common\models\Price;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$area = 'party';
$this->title = Yii::t('app', 'Parties');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Helper::createButton( $area ); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'place_id',
                'value' => function( $model ) {
                    /** @var \common\models\Party $model */
                    return $model->placeLabel;
                },
                'filter' => Place::getDropDownList()[0]
            ],
            [
                'attribute' => 'timestamp',
                'format' => 'datetime',
                'filter'  => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'timestamp',
                    'options' => [
                        'autocomplete' => 'off',
                        'placeholder' => Yii::t('app','Date filter') .'...'
                    ],
                    'pluginOptions' => [
                        'forceParse' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ])
            ],
            [
                'attribute' => 'price_id',
                'value' => function( $model ) {
                    /** @var \common\models\Party $model */
                    return $model->priceLabel;
                },
                'filter' => Price::getDropDownList()[0]
            ],
            'phone',
            'max_members',
            'is_blocked:boolean',
            'closed:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ]
        ]
    ]); ?>
    <?php // todo - add paid column!!! ?>
    <?php // todo - add members column!!! ?>
    <?php // todo - add is_complete column!!! ?>
    <?php Pjax::end(); ?>
</div>
