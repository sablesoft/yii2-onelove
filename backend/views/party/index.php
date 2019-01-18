<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PartySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Party', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'place_id', // todo - place name
            'date', // todo - prepare from timestamp
            'time', // todo - prepare from timestamp
            'timestamp', // todo - format
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn']
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>
