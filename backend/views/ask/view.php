<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */

$area = 'ask';
$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Asks'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ask-view">
    <h1><?= Html::encode( $this->title ); ?></h1>
    <p><?= Helper::viewButtons( $area, $model ); ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'partyLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'party.view', $model->partyLabel, $model->partyUrl  )
            ],
            [
                'attribute' => 'memberLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'member.view', $model->memberLabel, $model->memberUrl )
            ],
            'comment:text',
            'confirmed:boolean',
            'visited:boolean',
            'paid',
            'processed:boolean',
            'is_blocked:boolean',
            'closed:boolean',
            'operatorLabel'
        ]
    ]) ?>
<?php // todo - add is repeat flag ?>
</div>
