<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Place */

$this->title = Yii::t('app/backend', 'Update Place: {0}', $model->name );
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="place-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
