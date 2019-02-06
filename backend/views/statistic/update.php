<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Statistic */

$this->title = Yii::t('app/backend', 'Update Statistic: {name}', [
    'name' => $model->date,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Statistics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->date, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="statistic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
