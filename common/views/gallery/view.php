<?php

use onmotion\gallery\Gallery;
use \yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use noam148\imagemanager\components\ImageManagerInputWidget;

/* @var $this yii\web\View */
/* @var $model onmotion\gallery\models\Gallery */
/* @var $photos \common\models\GalleryPhoto[] */
/* @var $photoModel \common\models\GalleryPhoto */

$area = 'gallery';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app/backend', 'Gallery'), 'url' => ["/$area"]];
$this->params['breadcrumbs'][] = $model->name;

$this->title = Yii::t('app/backend', 'Gallery' ) . ' : ' . $model->name;

$this->registerJs(<<<JS
$('#preloader').show();
$('body').css('overflow', 'hidden');
window.onload = function() {
	$('body').css('overflow', 'auto');
    $('#preloader').hide();
};
$("[data-toggle='tooltip']").tooltip();
JS
);
            echo Html::beginTag('div', ['class' => 'gallery-view']);
            try {
                echo \yii\bootstrap\Collapse::widget([
                    'items' => [
                        [
                            'label' => $model->name . ' (' . count((array)$photos) . ' photos)',
                            'content' => !empty( $model->descr ) ? $model->descr : ''
                        ]
                    ],
                    'options' => [

                        'class' => 'header-collapse'
                    ]
                ]);
            } catch( Exception $e ) {}
            $galleryName = $model->name;

            $size = 100;
            /** @var \noam148\imagemanager\components\ImageManagerGetPath $imageManager */
            $imageManager = \Yii::$app->imagemanager;
            if( !empty( $photos ) ) {
                foreach( $photos as $photo ) {
                    $items[] =
                        [
                            'original' => $imageManager->getImagePath( $photo->image_id, $size * 100, $size * 100 ),
                            'thumbnail' => $imageManager->getImagePath( $photo->image_id, $size, $size ),
                            'options' => [
                                'title' => $galleryName,
                                'data-id' => $photo->photo_id
                            ]
                        ];
                };
            } else {
                echo 'There is no photos yet...';
            }
            ?>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <?php
                    if (!empty( $items ) )
                        try {
                            echo Gallery::widget([
                                'id' => 'gallery-links',
                                'items' => $items,
                                'pluginOptions' => [
                                    'slideshowInterval' => 2000,
                                    'transitionSpeed' => 200,
                                ],
                            ]);
                        } catch( Exception $e ) {}
                    ?>
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="row gallery-view-control">
                <div class="col-sm-1">
                    <?php
                    if( Yii::$app->user->can( "$area.add" ) )
                        try {
                        $form = ActiveForm::begin(['id' => 'imageSelect', 'action' => 'add']);
                            echo $form->field( $photoModel, 'gallery_id')->hiddenInput()->label(false );
                            echo $form->field( $photoModel, 'image_id' )->widget( ImageManagerInputWidget::class, [
                                'aspectRatio' => (16/9), //set the aspect ratio
                                'cropViewMode' => 1, //crop mode, option info: https://github.com/fengyuanchen/cropper/#viewmode
                                'showPreview' => false, //false to hide the preview
                                'showDeletePickedImageConfirm' => false //on true show warning before detach image
                            ])->label( false );
                        ActiveForm::end();
                        } catch (Exception $e) {}
                    ?>
                </div>
                <div class="col-sm-11 edit-control">
                 <?php
                if( Yii::$app->user->can( "$area.photos-delete" ) )
                    echo Html::a('<i class="glyphicon glyphicon-pencil"></i>', ['#'],
                        ['title' => 'Edit mode', 'class' => 'btn btn-default', 'id' => 'check-toggle',
                            'data-toggle' => "tooltip", 'data-placement' => "top", 'data-trigger' => "hover"]);
                if( Yii::$app->user->can( "$area.photos-delete" ) )
                    echo Html::a('<i class="glyphicon glyphicon-check"></i>', ['#'],
                        ['title' => 'Check all', 'class' => 'btn btn-default', 'style' => "display:none", 'id' => 'check-all',
                            'data-toggle' => "tooltip", 'data-placement' => "top", 'data-trigger' => "hover"]);
                if( Yii::$app->user->can( "$area.photos-delete" ) )
                    echo Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['#'],
                        ['title' => 'Reset', 'class' => 'btn btn-default', 'style' => "display:none", 'id' => 'reset-all',
                            'data-toggle' => "tooltip", 'data-placement' => "top", 'data-trigger' => "hover"]);

                if( Yii::$app->user->can( "$area.photos-delete" ) )
                    echo Html::a('<i class="glyphicon glyphicon-trash"></i>', Url::toRoute('photos-delete'),
                        ['title' => 'Delete photos', 'class' => 'btn btn-danger', 'style' => "display:none", 'id' => 'photos-delete-btn',
                            'data-toggle' => "tooltip", 'data-placement' => "top", 'data-trigger' => "hover",
                            'role' => 'modal-toggle',
                            'data-modal-title'=>'Delete photos',
                            'data-modal-body'=>'Are you sure?',
                        ]);
                    ?>
                </div>
            </div>
<?php
echo Html::endTag('div');

Modal::begin([
    "id" => "gallery-modal",
    'header' => '<h4 class="modal-title"></h4>',
    "footer" =>
        Html::a('Close', ['#'],
            ['title' => 'Cancel', 'class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
        Html::a('ОК', Url::toRoute('photos-delete'),
            ['title' => '', 'class' => 'btn btn-primary', 'id' => 'photos-delete-confirm-btn']),
]);

Modal::end();

echo Html::beginTag('div', ['class' => 'preloader']);
echo Html::tag('div', Html::tag('span', '100', ['class' => 'sr-only']), ['class'=>"progress-bar progress-bar-striped active", 'role'=>"progressbar",
    'aria-valuenow'=>"100", 'aria-valuemin'=>"0", 'aria-valuemax'=>"100", 'style'=>"width:100%"]);
echo Html::endTag('div');


$this->registerJs(<<<JS
jQuery( document ).ready( function() {
    jQuery('#gallery-modal').remove();
    jQuery('#galleryphoto-image_id').change( function() {
        if( jQuery( this ).val() ) {
            let form = jQuery('#imageSelect');
            jQuery.ajax({
                type: 'post',
                url: form.attr('action'),
                data: form.serialize(),
                success: function( res ) {
                    location.reload();
                },
                error: function( res ) {
                    location.reload();
                }
            });
        }
    });
});
JS
);
?>