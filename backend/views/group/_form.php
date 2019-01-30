<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'label')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'rule')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'is_blocked')->checkbox(); ?>
            <div class="form-group">
                <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']); ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
