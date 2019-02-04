<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Helper;
use common\models\Member;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$area = 'member';
$this->title = Yii::t('app/backend', 'Members');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-index">

    <h1><?= Html::encode( $this->title ); ?></h1>
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
                    'attribute' => 'photo',
                    'value' => function( $model ) {
                        /** @var \common\models\Member $model */
                        return $model->getImagePath([ 'width' => 100 ]);
                    },
                    'format' => 'image',
                    'enableSorting' => false,
                    'filter' => false
                ],
                'name',
                [
                    'attribute' => 'sex',
                    'value' => function ($model) {
                        /** @var \common\models\Member $model */
                        return $model->sexLabel;
                    },
                    'filter' => Member::getSexDropDownList()
                ],
                [
                    'attribute' => 'age',
                    'value' => function ($model) {
                        /** @var \common\models\Member $model */
                        return $model->ageLabel;
                    }
                ],
                [
                    'attribute' => 'group_id',
                    'value'     => function( $model ) {
                        /** @var \common\models\Member $model */
                        return $model->groupLabel;
                    },
                    'filter' => \common\models\Group::getDropDownList()[0]
                ],
                [
                    'attribute' => 'phone',
                    'value' => function ($model) {
                        /** @var \common\models\Member $model */
                        return $model->maskedPhone;
                    }
                ],
                'email:email',
                'is_blocked:boolean',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'visibleButtons' => Helper::visibleButtons($area)
                ]
            ]
        ]);
    } catch( Exception $e ) {
        \Yii::$app->session->addFlash('error', $e->getMessage() );
        $this->context->redirect(['member/index']);
    } ?>
    <?php // todo - add paid sum column!!! ?>
    <?php // todo - add parties sum column!!! ?>
    <?php Pjax::end(); ?>
</div>
