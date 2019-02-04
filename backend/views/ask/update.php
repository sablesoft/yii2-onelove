<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */

$this->title = Yii::t('app/backend', 'Update Ask: {0}', $model->label );
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Asks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="ask-update">

    <h1><?= Html::encode( $this->title ); ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]); ?>

</div>
