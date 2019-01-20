<?php

use yii\helpers\Html;
use common\models\Place;
use common\models\Price;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Party */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="party-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field( $model, 'place_id')
                ->dropDownList( ...Place::getDropDownList([ 'selected' => true ]) )
                ->label( Yii::t('app', 'Place') ); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'timestamp')->textInput() // todo - date time picker ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'price_id')
                ->dropDownList( ...Price::getDropDownList([ 'selected' => true ]) )
                ->label( Yii::t('app', 'Price') ); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'max_members')->input('number'); // todo - validate min max ?>
        </div>
    </div>

    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton( Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
