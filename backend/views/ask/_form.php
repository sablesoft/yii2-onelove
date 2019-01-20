<?php

use yii\helpers\Html;
use common\models\Party;
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
            <?php // todo - disabled for not now: ?>
            <?= $form->field( $model, 'party_id' )
                // todo - only active parties?
                ->dropDownList( ...Party::getDropDownList([
                    'prompt' => Yii::t('app', 'Select asked party')
                ]) )->label( Yii::t('app', 'Party' ) ); ?>
        </div>
        <div class="col-sm-6">
            <?php // todo - disabled for not now: ?>
            <?= $form->field($model, 'member_id')
                ->dropDownList( ...Member::getDropDownList([
                    'prompt' => Yii::t('app', 'Select ask member')
                ]) )->label( Yii::t('app', 'Member' ) ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2 col-xs-4">
            <br>
            <?= $form->field( $model, 'processed')->checkbox(); ?>
        </div>
        <div class="col-sm-2  col-xs-4">
            <br>
            <?= $form->field( $model, 'confirmed')->checkbox(); ?>
        </div>
        <div class="col-sm-2  col-xs-4">
            <br>
            <?= $form->field( $model, 'visited')->checkbox(); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field( $model, 'paid')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <br>
            <div class="form-group">
                <?= Html::submitButton(
                        Yii::t('yii', 'Save'),
                        ['class' => 'btn btn-success']
                ); ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
