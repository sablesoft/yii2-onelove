<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */

$area = 'ask';
$this->title = $model->label;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Asks'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ask-view">
    <h1><?= Html::encode( $this->title ); ?></h1>
    <p>
        <?= Helper::viewButtons( $area, $model ); ?>
        <?= Helper::button( $area, 'accept', [
            'route' => ['accept', 'id' => $model->id ]
        ]); ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'maskedPhone',
            'sexLabel',
            'ageLabel',
            'groupLabel',
            'created_at:datetime',
            'updated_at:datetime'
        ]
    ]); ?>
</div>
