<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Party */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="party-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a( Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a( Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post'
            ]
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'place_id', // todo - place name
            'timestamp', // todo - format
            'max_members',
            'description:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

<?php // todo - add prices view!!! ?>

<?php // todo - add paid sum!!! ?>
<?php // todo - add members sum!!! ?>
</div>
<?php // todo - add members search!!! ?>
