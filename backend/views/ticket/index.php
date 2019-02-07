<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$area = 'ticket';
$this->title = Yii::t('app/backend', 'Tickets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?= Helper::createButton( $area ); ?></p>

    <?php try {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $searchModel->columns
        ]);
    } catch( Exception $e ) {
        \Yii::$app->session->addFlash('error', $e->getMessage() );
        $this->context->redirect('index');
    } ?>
    <?php Pjax::end(); ?>
</div>
