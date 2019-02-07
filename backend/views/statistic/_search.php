<?php

use yii\helpers\Html;
use common\models\User;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\StatisticSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statistic-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'dateFrom')->widget(
                DatePicker::class,
                [
                    'options' => [
                        'autocomplete' => 'off',
                        'placeholder' => Yii::t('app/backend','From')
                    ],
                    'pluginOptions' => [
                        'forceParse' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]
            )->label(false); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'dateTo')->widget(
                'kartik\date\DatePicker',
                [
                    'options' => [
                        'autocomplete' => 'off',
                        'placeholder' => Yii::t( 'app/backend', 'To')
                    ],
                    'pluginOptions' => [
                        'forceParse' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]
            )->label(false); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field( $model, 'groupBy' )->dropDownList( $model->groupLabels ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field( $model, 'operatorIds' )->widget(
                Select2::class,
                [
                    'data' => User::findRoleList()[0],
                    'options' => [
                        'placeholder' => Yii::t('app/backend', 'Select operators...'),
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ]
                ]);
            ?>
        </div>
        <div class="col-sm-4">
            <br>
            <div class="form-group">
                <?= Html::submitButton(
                        Yii::t('app/backend', 'Search Statistic'),
                        ['class' => 'btn btn-primary']
                ); ?>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
