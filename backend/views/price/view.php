    <?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $model common\models\Price */
$area = 'price';
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="price-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><?= Helper::viewButtons( $area, $model ); ?></p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'base',
            'repeat',
            'company',
            'is_default:boolean',
            'is_blocked:boolean',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
