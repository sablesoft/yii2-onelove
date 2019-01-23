<?php

use yii\helpers\Html;
use common\models\Member;
use yii\widgets\ActiveForm;
use common\models\User;

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
                            'placeholder' => Yii::t('app','Select your day of birth') .' ...'
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
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) // todo - file uploader ?>
            <?= $form->field($model, 'sex')->dropDownList( Member::getSexDropDownList() ); ?>
            <?= $form->field($model, 'user_id')->dropDownList(
                ...User::getDropDownList([
                'prompt' => Yii::t('app', 'Select user account')
            ])
            ); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'phone')->widget( 'yii\widgets\MaskedInput', $model->maskedPhoneConfig ); ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) // todo - email validation ?>
            <br>
            <?= $form->field($model, 'is_blocked')->checkbox(); ?>
        </div>
    </div>

    <?= $form->field($model, 'resume')->textarea(['rows' => 6]); // todo - editor ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
