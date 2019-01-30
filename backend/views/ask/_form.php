<?php

use yii\helpers\Html;
use common\models\Member;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ask-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field( $model, 'name')->textInput(); ?>
            <?= $form->field( $model, 'phone')
                ->widget( 'yii\widgets\MaskedInput', $model->maskedPhoneConfig ); ?>
            <br>
            <?= Html::submitButton(
                Yii::t('yii', 'Save'),
                ['class' => 'btn btn-success']
            ); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field( $model, 'sex')->dropDownList( Member::getSexDropDownList() ); ?>
            <?= $form->field( $model, 'age')->input('number'); ?>
            <?= $form->field( $model, 'group_id')->dropDownList( \common\models\Group::getDropDownList()[0] ); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
