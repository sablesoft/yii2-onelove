<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Party */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="party-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'place_id')->textInput() // todo - places dropdown ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'timestamp')->textInput() // todo - date time picker ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'price_id')->textInput() // todo - prices dropdown ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'max_members')->input('number'); // todo - validate min max ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton( Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
