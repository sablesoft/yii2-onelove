<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;

/* @var $view yii\web\View */
/* @var $model common\models\Ask */
$view = Yii::$app->view;
$view->title = $model->label;
$view->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Asks'),
    'url' => ['index']
];
$view->params['breadcrumbs'][] = $view->title;
\yii\web\YiiAsset::register( $view );
?>
<div class="ask-view">
    <h1><?= Html::encode( $view->title ); ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'maskedPhone',
            'sexLabel',
            'ageLabel',
            'created_at:datetime'
        ]
    ]); ?>
</div>
