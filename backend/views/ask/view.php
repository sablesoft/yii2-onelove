<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ask */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Asks'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ask-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(
                Yii::t('yii', 'Update'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
        ); ?>
        <?= Html::a(
                Yii::t('yii', 'Delete'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii',
                            'Are you sure you want to delete this item?'
                        ),
                        'method' => 'post',
                    ],
                ]
        ); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'partyLabel',
                'format' => 'raw',
                'value' => Html::a( $model->partyLabel, $model->partyUrl )
            ],
            [
                'attribute' => 'memberLabel',
                'format' => 'raw',
                'value' => Html::a( $model->memberLabel, $model->memberUrl )
            ],
            'processed:boolean',
            'confirmed:boolean',
            'visited:boolean',
            'paid'
        ]
    ]) ?>
<?php // todo - add is repeat flag ?>
</div>
