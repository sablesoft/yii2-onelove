<?php

use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Statistic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statistic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ask_make')->input('number'); ?>
    <?= $form->field($model, 'ask_reject')->input('number'); ?>
    <?= $form->field($model, 'ask_member')->input('number'); ?>
    <?= $form->field($model, 'ask_accept')->input('number'); ?>
    <?= $form->field($model, 'party_close')->input('number'); ?>
    <?= $form->field($model, 'ticket_close')->input('number'); ?>
    <?= $form->field($model, 'member_visit')->input('number'); ?>
    <?= $form->field($model, 'member_pay')->input('number'); ?>
    <?= $form->field($model, 'operator_id')->dropDownList( ...User::findRoleList() ); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
