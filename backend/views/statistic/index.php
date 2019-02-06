<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\StatisticSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$area = 'statistic';
$this->title = Yii::t('app/backend', 'Statistics');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-index">

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
                'attribute' => 'date',
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date',
                    'options' => [
                        'autocomplete' => 'off',
                        'placeholder' => Yii::t('app/backend','Date filter') .'...'
                    ],
                    'pluginOptions' => [
                        'forceParse' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ])
            ],
            'ask_make',
            'ask_reject',
            'ask_member',
            'ask_accept',
            [
                'attribute' => 'operator_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /** @var \backend\models\Statistic $model */
                    return Helper::canLink('user.view', $model->operatorLabel, $model->operatorUrl);
                },
                'filter' => \common\models\User::findRoleList()[0]
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
