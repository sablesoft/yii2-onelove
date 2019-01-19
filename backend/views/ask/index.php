<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Asks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ask-index">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ask'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'party_id', // todo - party label
            'member_id', // todo - member label
            'processed', // todo - yesno label
            'confirmed', // todo - yesno label
            'visited', // todo - yesno label
            'paid',

            ['class' => 'yii\grid\ActionColumn']
        ]
    ]); ?>
    <?php // todo - add is repeat flag column ?>
    <?php Pjax::end(); ?>
</div>
