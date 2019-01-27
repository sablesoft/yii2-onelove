<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $view yii\web\View */
/* @var $model common\models\Ask */
$view = Yii::$app->view;
$view->title = $model->label;
\yii\web\YiiAsset::register( $view ); ?>
<p style="font-weight: bold;">
<?php echo Html::a(
        Yii::t('app', 'Open all asks'),
        Url::to( 'http://admin.onelove.by/ask', true ),
        ['class'=>'btn btn-primary']
);
?>
<span> | </span>
<?php echo Html::a(
    Yii::t('app', 'View Ask'),
    Url::to( 'http://admin.onelove.by/ask/view?id=' . $model->id, true ),
    ['class'=>'btn btn-primary']
);
?>
<span> | </span>
<?php echo Html::a(
    Yii::t('app', 'Accept Ask'),
    Url::to( 'http://admin.onelove.by/ask/accept?id=' . $model->id, true ),
    ['class'=>'btn btn-primary']
);
?>
</p>
<div class="ask-view">
    <h1><?= Html::encode( $view->title ); ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'maskedPhone',
            'sexLabel',
            'ageLabel',
            'created_at:datetime'
        ]
    ]); ?>
</div>
