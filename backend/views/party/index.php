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
$this->title = Yii::t('app/backend', 'Parties');
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
        'columns' => $searchModel->columns
    ]); ?>
    <?php // todo - add paid column!!! ?>
    <?php // todo - add members column!!! ?>
    <?php Pjax::end(); ?>
</div>
