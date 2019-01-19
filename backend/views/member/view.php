<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Member */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="member-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a( Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a( Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'photo', // todo show html image!!
            'name',
            'sex', // todo labels
            'age',
            'dob', // todo datetime
            'phone',
            'email:email',
            'resume:ntext',
//            'user_id', todo - user flag!!!
            'created_at', // todo format
            'updated_at', // todo format
        ],
    ]) ?>

<?php // todo - add paid sum!!! ?>
<?php // todo - add parties sum!!! ?>
</div>

<?php // todo - add parties search!!! ?>
