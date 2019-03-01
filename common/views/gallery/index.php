<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $gallerySelect array */
/* @var $gallerySetting \common\models\Setting */
/* @var $searchModel onmotion\gallery\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$area = 'gallery';
$this->title = Yii::t('app/backend', 'Gallery');
$dataProvider->pagination->pageSize = 20;
?>
<div class="gallery-index">
    <h2><?= Yii::t('app/backend', 'All galleries')?></h2>
            <?php
    if( Yii::$app->user->can( "$area.create" ) )
        echo Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
            ['title' => 'Create Gallery', 'class' => 'btn btn-default',
                'method' => 'get',
                'role' => 'modal-toggle',
                'data-modal-title'=>'Create Gallery',
            ]);

        try {
            echo \yii\widgets\ListView::widget([
                'id' => 'gallery-listview',
                'dataProvider' => $dataProvider,
                'layout' => "{items}\n{pager}\n{summary}",
                'itemView' => function ($model) {
                    return $this->render('galleryItem', ['model' => $model]);
                },
                'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                    'nextPageLabel' => '>',
                    'prevPageLabel' => '<',
                ],

            ]);
        } catch (Exception $e) {}

        ?>
</div>
<div class="setting-form">

    <h2><?= Yii::t('app/backend', 'Selected gallery setting')?></h2>
    <br>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field( $gallerySetting, 'label')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field( $gallerySetting, 'key')->textInput([
                    'maxlength' => true, 'disabled' => !empty( $gallerySetting->key )
            ]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field( $gallerySetting, 'value')->widget(\kartik\select2\Select2::class, [
                'data' => $gallerySelect,
                'language' => 'ru',
                'options' => [
                    'placeholder' => Yii::t('app/backend', 'Select gallery for show'),
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-sm-12">
            <?= $form->field( $gallerySetting, 'description')->textarea(['rows' => 4]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
Modal::begin([
    "id" => "gallery-modal",
    'header' => '<h4 class="modal-title"></h4>',
    "footer" =>
        Html::a('Close', ['#'],
            ['title' => 'Cancel', 'class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
        Html::a('ОК', Url::to('#'),
            ['title' => '', 'class' => 'btn btn-primary', 'id' => 'modal-confirm-btn']),
]);

echo Html::beginTag('div', ['class' => 'preloader']);
echo Html::tag('div', Html::tag('span', '100', ['class' => 'sr-only']),
    [
        'class'=>"progress-bar progress-bar-striped active", 'role'=>"progressbar",
        'aria-valuenow'=>"100", 'aria-valuemin'=>"0", 'aria-valuemax'=>"100", 'style'=>"width:100%"
    ]);
echo Html::endTag('div');
Modal::end(); ?>
