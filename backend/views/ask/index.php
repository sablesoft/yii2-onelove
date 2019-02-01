<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Member;
use common\models\Helper;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$area = 'ask';
$this->title = Yii::t('app', 'Asks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Helper::createButton( $area ); ?>
        <?= Helper::button(
                $area, 'reject-all',
                [
                    'label'     => 'Reject All',
                    'class'     => 'btn btn-danger',
                    'callback'  => ['common\models\Ask', 'noEmpty' ],
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to reject all asks?'
                        ),
                        'method' => 'post'
                    ]
                ]
        ); ?>
        <?= Helper::button(
                $area, 'accept-all',
                [
                    'label' => 'Accept All',
                    'class' => 'btn btn-warning',
                    'callback'  => ['common\models\Ask', 'noEmpty' ],
                    'data' => [
                        'confirm' => Yii::t('app',
                            'Are you sure you want to accept all asks?'
                        ),
                        'method' => 'post'
                    ]
                ]
        ); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'phone',
                'value' => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->maskedPhone;
                }
            ],
            [
                'attribute' => 'age',
                'value'     => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->ageLabel;
                }
            ],
            [
                'attribute' => 'sex',
                'value'     => function( $model ) {
                    /** @var \common\models\Member $model */
                    return $model->sexLabel;
                },
                'filter' => Member::getSexDropDownList()
            ],
            [
                'attribute' => 'group_id',
                'value'     => function( $model ) {
                    /** @var \common\models\Ask $model */
                    return $model->groupLabel;
                },
                'filter' => \common\models\Group::getDropDownList()[0]
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter'  => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'options' => [
                        'autocomplete' => 'off',
                        'placeholder' => Yii::t('app','Date filter') .'...'
                    ],
                    'pluginOptions' => [
                        'forceParse' => true,
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{member-save} {accept} {view} {update} {delete}',
                'visibleButtons' => Helper::visibleButtons( $area, ['accept', 'member-save'] ),
                'buttons' => [
                    'member-save' => function($url, $model, $key) {
                        $url = Yii::$app->getUrlManager()->createUrl([ 'ask/member-save','id'=>$model->id ]);
                        $class = 'heart-empty';
                        $label = 'Save';
                        $member = Member::findOne([ 'phone' => $model->id ]);
                        if( $member ) {
                            $class = 'heart';
                            $label = 'Update';
                        }
                        return Html::a( "<span class='glyphicon glyphicon-$class'></span>", $url,
                            ['title' => Yii::t('app', "Member $label"), 'data-pjax' => '0']);
                    },
                    'accept' => function($url, $model, $key) {
                        $url = Yii::$app->getUrlManager()->createUrl([ 'ask/accept','id'=>$model->id ]);
                        return Html::a( '<span class="glyphicon glyphicon-plus"></span>', $url,
                            ['title' => Yii::t('app', 'Accept Ask'), 'data-pjax' => '0']);
                    }
                ]
            ]
        ]
    ]); ?>
    <?php Pjax::end(); ?>
</div>
