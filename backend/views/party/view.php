<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $model common\models\Party */
$area = 'party';
$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Parties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="party-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Helper::viewButtons( $area, $model ); ?>
        <?php if( !$model->closed ) { ?>
        <?= Helper::button( $area, 'close', [
            'route' => ['close', 'id' => $model->id ],
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => Yii::t('app/backend',
                    'Are you sure you want to close this party?'
                ),
                'method' => 'post'
            ]
        ]); ?>
        <?php } ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'placeLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'place.view', $model->placeLabel, $model->placeUrl )
            ],
            'timestamp:datetime',
            [
                'attribute' => 'priceLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'price.view', $model->priceLabel, $model->priceUrl )
            ],
            'phoneLabel',
            [
                'attribute' => 'operator_ids',
                'format' => 'text',
                'value' => $model->operatorsLabel
            ],
            'max_members',
            'description:ntext',
            'is_blocked:boolean',
            'closed:boolean',
            'created_at:datetime',
            'updated_at:datetime'
        ]
    ]); ?>

<?php // todo - add prices view!!! ?>

<?php // todo - add paid sum!!! ?>
<?php // todo - add members sum!!! ?>
</div>
<?php // todo - add members search!!! ?>
