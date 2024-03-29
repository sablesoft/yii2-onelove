<?php

use yii\helpers\Html;
use common\models\Helper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = $model->label;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register( $this );
?>
<div class="ticket-view">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'partyLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'party.view', $model->partyLabel, $model->partyUrl )
            ],
            [
                'attribute' => 'memberLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'member.view', $model->memberLabel, $model->memberUrl )
            ],
            'comment:ntext',
            'visited:boolean',
            'paid:currency',
            'is_blocked:boolean',
            'closed:boolean',
            [
                'attribute' => 'operatorLabel',
                'format' => 'raw',
                'value' => Helper::canLink( 'user.view', $model->operatorLabel, $model->operatorUrl )
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
