<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $model common\models\Place */
$area = 'place';
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
    <p><?= Helper::viewButtons( $area, $model ); ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'photo', // todo - image html!!
            'name',
            'address',
            'maskedPhone',
            'map',
            'is_default:boolean',
            'is_blocked:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

<?php // todo - add paid sum!!! ?>
<?php // todo - add members sum!!! ?>
<?php // todo - add party sum!!! ?>
</div>

<?php // todo - add parties search!!! ?>
<?php // todo - add members search!!! ?>
