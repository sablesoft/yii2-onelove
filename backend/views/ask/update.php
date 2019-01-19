<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */

$this->title = Yii::t('app', 'Update Ask: {0}', $model->id );
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Asks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="ask-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
