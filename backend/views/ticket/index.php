<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Party;
use common\models\Member;
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
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'party_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \common\models\Ticket $model */
                        return Helper::canLink('party.view', $model->partyLabel, $model->partyUrl);
                    },
                    'filter' => Party::getDropDownList()[0]
                ],
                [
                    'attribute' => 'member_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \common\models\Ticket $model */
                        return Helper::canLink('member.view', $model->memberLabel, $model->memberUrl);
                    },
                    'filter' => Member::getDropDownList()[0]
                ],
                [
                    'attribute' => 'memberSex',
                    'value' => function ($model) {
                        /** @var \common\models\Ticket $model */
                        return $model->memberSexLabel;
                    },
                    'filter' => Member::getSexDropDownList()
                ],
                [
                    'attribute' => 'memberAge',
                    'value' => function ($model) {
                        /** @var \common\models\Ticket $model */
                        return $model->memberAgeLabel;
                    }
                ],
                'visited:boolean',
                'paid:currency',
                'is_blocked:boolean',
                'closed:boolean',
                [
                    'attribute' => 'updated_by',
                    'format' => 'raw',
                    'value' => function ($model) {
                        /** @var \common\models\Ticket $model */
                        return Helper::canLink('user.view', $model->operatorLabel, $model->operatorUrl);
                    },
                    'filter' => \common\models\User::findRoleList()[0]
                ],
                'created_at:datetime',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons' => Helper::visibleButtons($area)
                ]
            ]
        ]);
    } catch( Exception $e ) {
        \Yii::$app->session->addFlash('error', $e->getMessage() );
        $this->context->redirect('index');
    } ?>
    <?php Pjax::end(); ?>
</div>
