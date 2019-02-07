<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
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
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterRowOptions' => [
            'style' => 'display:none;'
        ],
        'pjax' => true,
        'striped' => true,
        'showPageSummary' => true,
        'columns' => $searchModel->columns
    ]); ?>
    <?php Pjax::end(); ?>
</div>
