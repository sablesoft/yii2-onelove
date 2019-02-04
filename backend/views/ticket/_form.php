<?php

use yii\helpers\Html;
use common\models\Party;
use common\models\Member;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <?php // todo - disabled for not new: ?>
                    <?= $form->field( $model, 'party_id' )
                        // todo - only active parties?
                        ->dropDownList( ...Party::getDropDownList([
                            'prompt' => Yii::t('app/backend', 'Select asked party')
                        ]) )->label( Yii::t('app/backend', 'Party' ) ); ?>
                </div>
                <div class="col-sm-12">
                    <?php // todo - disabled for not new: ?>
                    <?= $form->field($model, 'member_id')
                        ->dropDownList( ...Member::getDropDownList([
                            'prompt' => Yii::t('app/backend', 'Select ask member')
                        ]) )->label( Yii::t('app/backend', 'Member' ) ); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?= $form->field( $model, 'comment')->textarea(['rows' => '4']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2  col-xs-4">
            <br>
            <?= $form->field( $model, 'visited')->checkbox(); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field( $model, 'paid')->textInput(); ?>
        </div>
        <div class="col-sm-2">
            <br>
            <?= $form->field( $model, 'is_blocked')->checkbox(); ?>
        </div>
        <div class="col-sm-2">
            <br>
            <?= $form->field( $model, 'closed')->checkbox(); ?>
        </div>
        <div class="col-sm-2">
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
