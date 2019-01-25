<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Helper;
use common\models\Member;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$area = 'member';
$this->title = Yii::t('app', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <h1><?= Html::encode( $this->title ); ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Helper::createButton( $area ); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                // todo - photo column!!!
                'attribute' => 'photo',
                'filter' => false
            ],
            'name',
            [
                'attribute' => 'sex',
                'value'     => function( $model ) {
                    /** @var \common\models\Member $model */
                    return $model->sexLabel;
                },
                'filter' => Member::getSexDropDownList()
            ],
            [
                'attribute' => 'age',
                'value'     => function( $model ) {
                    /** @var \common\models\Member $model */
                    return $model->ageLabel;
                }
            ],
            [
                'attribute' => 'dob',
                'format' => 'date',
                'filter'  => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'dob',
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
                'attribute' => 'phone',
                'value' => function( $model ) {
                    /** @var \common\models\Member $model */
                    return $model->maskedPhone;
                }
            ],
            'email:email',
            'is_blocked:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => Helper::visibleButtons( $area )
            ]
        ]
    ]); ?>
    <?php // todo - add paid sum column!!! ?>
    <?php // todo - add parties sum column!!! ?>
    <?php Pjax::end(); ?>
</div>
