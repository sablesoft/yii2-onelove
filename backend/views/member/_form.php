<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    < ?= $form->field($model, 'user_id')->textInput() todo !!! ?>-->

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) // todo - file uploader ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'age')->textInput(); // todo - age validation ?>

    <?= $form->field($model, 'dob')->textInput(); // todo - date picker ?>

    <?= $form->field($model, 'sex')->textInput(); // todo - sex dropdown!!! ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) // todo - phone mask ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) // todo - email validation ?>

    <?= $form->field($model, 'resume')->textarea(['rows' => 6]); // todo - editor ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
