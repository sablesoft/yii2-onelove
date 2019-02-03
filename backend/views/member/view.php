<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;

/* @var $this yii\web\View */
/* @var $model common\models\Member */
$area = 'member';
$this->title = $model->label;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Members'),
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
        'attributes' => [
            'imagePath:image',
            'name',
            'sexLabel',
            'groupLabel',
            'ageLabel',
            'dob:date',
            'maskedPhone',
            'email:email',
            'resume:ntext',
            'username',
            'is_blocked:boolean',
            'created_at:datetime',
            'updated_at:datetime'
        ]
    ]); ?>

<?php // todo - add paid sum!!! ?>
<?php // todo - add parties sum!!! ?>
</div>

<?php // todo - add parties search!!! ?>
