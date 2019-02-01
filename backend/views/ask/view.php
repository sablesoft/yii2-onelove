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
$member = \common\models\Member::findOne(['phone' => $model->id ]);
$label = $member ? 'Member Update' : 'Member Save';
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
        <?= Helper::button( $area, 'member-save', [
            'route' => ['member-save', 'id' => $model->id ],
            'label' => $label,
            'class' => 'btn btn-warning'
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
