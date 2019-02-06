<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */

$this->title = Yii::t('app/backend', 'Make Ask');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app/backend', 'Asks'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ask-make">

    <h1><?= Html::encode( $this->title ); ?></h1>

    <?= $this->render('_form', [
        'model' => $model
    ]); ?>

</div>
