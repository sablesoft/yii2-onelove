<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $view yii\web\View */
/* @var $model common\models\CallForm */
$view = Yii::$app->view;
$view->title = $model->label;
\yii\web\YiiAsset::register( $view );
echo Html::a(
        Yii::t('app/backend', 'Open all asks'),
        Url::to( 'http://admin.onelove.by/ask', true ),
        ['class'=>'btn btn-primary']
);
?>
<div class="ask-view">
    <h1><?= Html::encode( $view->title ); ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'maskedPhone',
            'created_at:datetime'
        ]
    ]); ?>
</div>
