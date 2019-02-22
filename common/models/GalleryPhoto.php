<?php
namespace common\models;

/**
 * Class GalleryPhoto
 * @package common\models
 *
 * @property $image_id
 */
class GalleryPhoto extends \onmotion\gallery\models\GalleryPhoto {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['gallery_id', 'image_id'], 'integer'],
            [['name'], 'string', 'max' => 20 ]
        ];
    }

}