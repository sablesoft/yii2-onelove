<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use noam148\imagemanager\components\ImageManagerInputWidget;

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
            <?= $form->field($model, 'map')->textarea(['rows' => 5]); ?>
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
        <div class="col-sm-6">
            <?= $form->field( $model, 'photo')->widget( ImageManagerInputWidget::class, [
                'aspectRatio' => ( 16 / 9 ), //set the aspect ratio
                'cropViewMode' => 1, //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
                'showPreview' => true, //false to hide the preview
                'showDeletePickedImageConfirm' => false, //on true show warning before detach image
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a(
                Yii::t('app/backend', 'Map Constructor'),
                $mapUrl, ['class' => 'btn btn-info', 'target' => '_blank']
        ); ?>
        <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
