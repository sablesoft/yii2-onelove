<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
$area = 'member';
$this->title = $model->label;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app/backend', 'Members'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="member-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Helper::viewButtons( $area, $model ); ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $model->columns
    ]); ?>
</div>

<?php // todo - add parties search!!! ?>
