<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Group */

$this->title = Yii::t('app/backend', 'Create Group');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
