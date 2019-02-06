<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Statistic */

$this->title = Yii::t('app/backend', 'Create Statistic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Statistics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
