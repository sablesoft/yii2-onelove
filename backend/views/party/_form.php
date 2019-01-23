<?php

use yii\helpers\Html;
use common\models\User;
use common\models\Place;
use common\models\Price;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Party */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="party-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field( $model, 'place_id')
                ->dropDownList( ...Place::getDropDownList([ 'selected' => true ]) )
                ->label( Yii::t('app', 'Place') ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'name')->textInput(); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'timestamp')->widget(
                'kartik\datetime\DateTimePicker',
                [
                    'options' => [
                        'autocomplete' => 'off',
                        'placeholder' => Yii::t('app','Select party date and time') .' ...'
                    ],
                    'removeButton'  => false,
                    'pluginOptions' => [
                        'forceParse' => true,
                        'format' => 'yyyy-mm-dd H:i',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'price_id')
                ->dropDownList( ...Price::getDropDownList([ 'selected' => true ]) )
                ->label( Yii::t('app', 'Price') ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'phone')->dropDownList( ...User::findPhonesList() ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'max_members')->input(
                'number', ['value' => $model->membersCount ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field( $model, 'operator_ids')->widget(Select2::class, [
                'data' => ( User::findRoleList('operator' ) )[0],
                'options' => [
                    'id' => 'operator_ids',
                    'multiple' => true
                ]
            ]) ?>
        </div>
        <div class="col-sm-2">
            <br>
            <?= $form->field($model, 'is_blocked')->checkbox(); ?>
        </div>
        <div class="col-sm-2">
            <br>
            <?= $form->field($model, 'closed')->checkbox(); ?>
        </div>
        <div class="col-sm-2">
            <br>
            <div class="form-group">
                <?= Html::submitButton( Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php ActiveForm::end(); ?>

</div>
