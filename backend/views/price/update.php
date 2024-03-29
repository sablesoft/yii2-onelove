<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Price */

$this->title = Yii::t('app/backend', 'Update Price: {0}', $model->name );
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="price-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
