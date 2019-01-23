<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Place */
/* @var $form yii\widgets\ActiveForm */
$mapUrl = 'https://yandex.ru/map-constructor/'; // todo - move to settings
?>

<div class="place-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'phone')->widget(
                            'yii\widgets\MaskedInput',
                            $model->maskedPhoneConfig
                    ); ?>
                </div>
            </div>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) // todo - uploader!! ?>
            <div class="row">
                <div class="col-sm-6">
                    <br>
                    <?= $form->field($model, 'is_default')
                        ->checkbox([ 'disabled' => (bool)$model->is_default ]); ?>
                </div>
                <div class="col-sm-6">
                    <br>
                    <?= $form->field($model, 'is_blocked')->checkbox(); ?>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'map')->textarea(['rows' => 3]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
