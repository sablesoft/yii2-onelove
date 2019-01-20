<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Place;
use common\models\Price;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Parties');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a( Yii::t('app', 'Create Party'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'value' => function( $model ) {
                    /** @var \common\models\Party $model */
                    return $model->formattedTimestamp;
                }
            ],
            [
                'attribute' => 'price_id',
                'value' => function( $model ) {
                    /** @var \common\models\Party $model */
                    return $model->priceLabel;
                },
                'filter' => Price::getDropDownList()[0]
            ],
//            'date', // todo - prepare from timestamp
//            'time', // todo - prepare from timestamp
            'max_members',

            ['class' => 'yii\grid\ActionColumn']
        ]
    ]); ?>
    <?php // todo - add paid column!!! ?>
    <?php // todo - add members column!!! ?>
    <?php // todo - add is_complete column!!! ?>
    <?php Pjax::end(); ?>
</div>
