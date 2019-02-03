<?php
namespace common\behavior;

use yii\base\Behavior;
use noam148\imagemanager\components\ImageManagerGetPath;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class ImageBehavior
 * @package common\behavior
 *
 * @property string $imagePath
 */
class ImageBehavior extends  Behavior {

    public $imageField  = 'image_id';
    public $imageWidth  = 300;
    public $imageHeight = 300;
    public $thumbnailMode = 'inset';

    /**
     * @param array $options
     * @return null|string
     */
    public function getImagePath( $options = [] ) {
        try {
            // preapre options:
            $field = ArrayHelper::remove( $options, 'field' );
            $width = ArrayHelper::remove( $options, 'width' );
            $height = ArrayHelper::remove( $options, 'height' );
            $mode = ArrayHelper::remove( $options, 'mode' );
            // prepare image id:
            $field = $field ?: $this->imageField;
            $id = $this->owner->$field;
            /** @var ImageManagerGetPath $manager */
            $manager = \Yii::$app->imagemanager;
            return $manager->getImagePath(
                $id,
                ( $width ?: $this->imageWidth ),
                ( $height ?: $this->imageHeight ),
                ( $mode ?: $this->thumbnailMode )
            );
        } catch( \Exception $e ) {
            return null;
        }
    }

    public function getImage( $options = [] ) {
        foreach([ 'width', 'height', 'mode', 'field' ] as $key )
            $pathOptions[] = ArrayHelper::remove( $options, $key );

        $path = $this->getImagePath( $pathOptions );

        return Html::img( $path, $options );
    }
}