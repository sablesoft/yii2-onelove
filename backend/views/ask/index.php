<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Party;
use common\models\Member;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\AskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$area = 'ask';
$this->title = Yii::t('app', 'Asks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ask-index">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Helper::createButton( $area ); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'party_id', // todo
                'value' => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->partyLabel;
                },
                'filter' => Party::getDropDownList()[0]
            ],
            [
                'attribute' => 'member_id',
                'value' => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->memberLabel;
                },
                'filter' => Member::getDropDownList()[0]
            ],
            'confirmed:boolean',
            'visited:boolean',
            'paid',
            'processed:boolean',
            'is_blocked:boolean',
            'closed:boolean',
            [
                'attribute' => 'updated_by',
                'value' => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->operatorLabel;
                },
                'filter' => \common\models\User::findRoleList()[0] // todo
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ]
        ]
    ]); ?>
    <?php // todo - add is active flag column ?>
    <?php Pjax::end(); ?>
</div>
