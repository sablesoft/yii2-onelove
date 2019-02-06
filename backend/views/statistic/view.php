<?php

use yii\helpers\Html;
use common\models\Helper;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Statistic */
$area = 'statistic';
$this->title = $model->date;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Statistics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register( $this );
?>
<div class="statistic-view">

    <h1><?= Html::encode( $this->title ); ?></h1>
    <p><?= Helper::viewButtons( $area, $model ); ?></p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date',
            'ask_make',
            'ask_reject',
            'ask_member',
            'ask_accept',
            'party_close',
            'ticket_close',
            'member_visit',
            'member_pay',
            'operatorLabel',
        ]
    ]); ?>

</div>
