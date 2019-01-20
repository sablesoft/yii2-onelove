<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Place */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Places'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="place-view">

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
                        'confirm' => Yii::t(
                                'yii',
                                'Are you sure you want to delete this item?'
                        ),
                        'method' => 'post'
                    ]
                ]
        ); ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'photo', // todo - image html!!
            'name',
            'address',
            'phone',
            'is_default:boolean',
            'map',
            'created_at',
            'updated_at',
        ],
    ]) ?>

<?php // todo - add paid sum!!! ?>
<?php // todo - add members sum!!! ?>
<?php // todo - add party sum!!! ?>
</div>

<?php // todo - add parties search!!! ?>
<?php // todo - add members search!!! ?>
