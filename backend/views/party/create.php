<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Party */

$this->title = Yii::t('app', 'Create Party');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="party-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
