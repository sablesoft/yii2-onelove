<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\AskSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ask-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'party_id') ?>

    <?= $form->field($model, 'member_id') ?>

    <?= $form->field($model, 'processed') ?>

    <?= $form->field($model, 'confirmed') ?>

    <?php // echo $form->field($model, 'visited') ?>

    <?php // echo $form->field($model, 'paid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('yii', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
