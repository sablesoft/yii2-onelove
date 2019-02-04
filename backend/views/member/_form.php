<?php

use yii\helpers\Html;
use common\models\User;
use common\models\Member;
use yii\widgets\ActiveForm;
use noam148\imagemanager\components\ImageManagerInputWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'trueAge')->input('number'); // todo - age validation ?>
            <?= $form->field($model, 'dob')->widget(
                'kartik\date\DatePicker',
                [
                    'options' => [
                            'placeholder' => Yii::t('app/backend','Select your day of birth') .' ...'
                    ],
                    'removeButton'  => false,
                    'pluginOptions' => [
                        'forceParse'    => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]
            ); ?>
            <?= $form->field($model, 'sex')->dropDownList( Member::getSexDropDownList() ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'phone')->widget( 'yii\widgets\MaskedInput', $model->maskedPhoneConfig ); ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'user_id')->dropDownList(
                ...User::getDropDownList([
                'prompt' => Yii::t('app/backend', 'Select user account')
            ])
            ); ?>
            <?= $form->field( $model, 'group_id')->dropDownList( \common\models\Group::getDropDownList()[0] ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field( $model, 'photo')->widget( ImageManagerInputWidget::class, [
                'aspectRatio' => ( 16 / 9 ), //set the aspect ratio
                'cropViewMode' => 1, //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
                'showPreview' => true, //false to hide the preview
                'showDeletePickedImageConfirm' => false, //on true show warning before detach image
            ]); ?>
        </div>
    </div>

    <?= $form->field($model, 'resume')->textarea(['rows' => 3]); // todo - editor ?>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'is_blocked')->checkbox(); ?>
        </div>
        <div class="col-sm-10">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
