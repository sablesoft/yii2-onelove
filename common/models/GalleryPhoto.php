<?php
namespace common\models;

/**
 * Class GalleryPhoto
 * @package common\models
 *
 * @property $image_id
 */
class GalleryPhoto extends \onmotion\gallery\models\GalleryPhoto {

    const DEFAULT_MOBILE_SIZE = 110;
    const DEFAULT_DESKTOP_SIZE = 220;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['gallery_id', 'image_id'], 'integer'],
            [['name'], 'string', 'max' => 20 ]
        ];
    }

    /**
     * @return array|GalleryPhoto[]|\yii\db\ActiveRecord[]|null
     */
    public static function findSelected() {
        if( !$id = Setting::findValue( Setting::SECTION_GALLERY ) )
            return null;

        return static::find()->where([ 'gallery_id' => $id ])->orderBy('name')->all();
    }

    /**
     * @return array|null
     */
    public static function findSelectedItems() {
        return ( $photos = static::findSelected() ) ?
            static::asItems( $photos ) : null;
    }

    /**
     * @param GalleryPhoto[] $photos
     */
    public static function asItems( array $photos, $size = null ) {
        $items = [];
        $size = $size ?: (
            Helper::isMobile() ? self::DEFAULT_MOBILE_SIZE : self::DEFAULT_DESKTOP_SIZE
        );
        /** @var \noam148\imagemanager\components\ImageManagerGetPath $imageManager */
        $imageManager = \Yii::$app->imagemanager;
        foreach( $photos as $photo )
            $items[] =
                [
                    'original' => $imageManager->getImagePath( $photo->image_id, $size * 100, $size * 100 ),
                    'thumbnail' => $imageManager->getImagePath( $photo->image_id, $size, $size ),
                    'options' => [
                        'title' => $photo->name,
                        'data-id' => $photo->photo_id
                    ]
                ];

        return $items;
    }
}
