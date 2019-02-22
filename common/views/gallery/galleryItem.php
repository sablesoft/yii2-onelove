<?php
/**
 * Created by PhpStorm.
 * User: kozhevnikov
 * Date: 17.03.2016
 * Time: 13:32
 */

use yii\helpers\Html;
use yii\helpers\Url;
use onmotion\helpers\Translator;

$area = 'gallery';
try {
    $size = 100;
    /** @var \noam148\imagemanager\components\ImageManagerGetPath $imageManager */
    $imageManager = \Yii::$app->imagemanager;
    $date = new DateTime($model->date);
} catch (Exception $e) {
}

?>

<div class="gallery-item">
    <div class="image">
        <?php
            echo Html::beginTag('div', ['class' => 'change-btns']);
        if( Yii::$app->user->can( "$area.delete" ) )
            echo Html::a('<i class="glyphicon glyphicon-trash"></i>', Url::toRoute(["delete", 'id'=>$model->gallery_id]),
                ['title' => 'Delete',
                    'class' => 'update-btn',
                    'role' => 'modal-toggle',
                    'data-modal-title'=>'Are you sure?',
                    'data-modal-body'=>'This will permanently delete all the pictures are in the gallery.',
                ]);
        if( Yii::$app->user->can( "$area.update" ) )
            echo Html::a('<i class="glyphicon glyphicon-pencil"></i>', Url::toRoute(["update", 'id'=>$model->gallery_id]), [
                'title' => 'Update',
                'method' => 'get',
                'class'=>"update-btn",
                'role'=>"modal-toggle",
                'data-modal-title'=>'Update',
            ]);
            echo Html::endTag('div');
        ?>

        <a class="image-wrap" href="<?= Url::toRoute(["view", 'id'=>$model->gallery_id]) ?>">
            <?php
            foreach( $model->galleryPhotos as $prevPhoto ) {
                echo \yii\helpers\Html::img( $imageManager->getImagePath( $prevPhoto->name, $size, $size ) );
            };
            ?>
        </a>
    </div>
    <div class="name">
        <span><?= $model->name ?></span>
        <span class="date-gallery"><?= ' (' . $date->format('d.m.Y') . ')'  ?></span>
    </div>
</div>
