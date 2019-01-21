<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Price */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="price-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <br>
            <?= $form->field($model, 'is_default')
                ->checkbox([ 'disabled' => (bool)$model->is_default ]); ?>
        </div>
        <div class="col-sm-3">
            <br>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'base')->textInput() // todo - validate money ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'repeat')->textInput() // todo - validate money ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'company')->textInput() // todo - validate money ?>
        </div>
        <div class="col-sm-3">
            <br>
            <?= $form->field($model, 'is_blocked')->checkbox(); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
