<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Member;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$area = 'ask';
$this->title = Yii::t('app', 'Asks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

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
                'attribute' => 'phone',
                'value' => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->maskedPhone;
                }
            ],
            'age',
            [
                'attribute' => 'sex',
                'value'     => function( $model ) {
                    /** @var \common\models\Member $model */
                    return $model->sexLabel;
                },
                'filter' => Member::getSexDropDownList()
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ]
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>
