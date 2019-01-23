<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * Class Helper
 * @package common\models
 */
class Helper {

    /**
     * @return string
     */
    public static function pageId() : string {
        $id = Yii::$app->id;
        $id .= '_' . Yii::$app->controller->id;
        $id .= '_' . Yii::$app->controller->action->id;

        return $id;
    }

    /**
     * @param string $permission
     * @param string $label
     * @param string|array $url
     * @return string
     */
    public static function canLink( string $permission, string $label, $url ) : string {
        return Yii::$app->user->can( $permission ) ?
            Html::a( $label, $url ) : $label;
    }

    /**
     * @param string $area
     * @return string
     */
    public static function createButton( string $area ) : string {
        $entity = ucfirst( $area );
        return Yii::$app->user->can( "$area.create" ) ?
            Html::a(
                Yii::t('app', "Create $entity" ),
                ['create'],
                ['class' => 'btn btn-success']
            ) : '';
    }

    /**
     * @param string $area
     * @param ActiveRecord $model
     * @return string
     */
    public static function viewButtons( string $area, ActiveRecord $model ) :string {
        $buttons = '';
        if( Yii::$app->user->can( "$area.update" ) )
            $buttons .= (string) Html::a(
                Yii::t('yii', 'Update'),
                ['update', 'id' => $model->id ],
                ['class' => 'btn btn-primary']
            );

        if( $buttons ) $buttons .= ' ';

        if( Yii::$app->user->can( "$area.delete" ) )
            $buttons .= (string) Html::a(
                Yii::t('yii', 'Delete'),
                ['delete', 'id' => $model->id ],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii',
                            'Are you sure you want to delete this item?'
                        ),
                        'method' => 'post',
                    ],
                ]
            );

        return $buttons;
    }

    /**
     * @param string $area
     * @return array
     */
    public static function visibleButtons( string $area ) :array {
        return [
            'view' => function( $model, $key, $index ) use ( $area ) {
                /** @var \common\models\BaseModel $model */
                return Yii::$app->user->can("$area.view" );
            },
            'update' => function( $model, $key, $index ) use ( $area ) {
                /** @var \common\models\BaseModel $model */
                return Yii::$app->user->can("$area.update" );
            },
            'delete' => function( $model, $key, $index ) use ( $area ) {
                /** @var \common\models\BaseModel $model */
                if( $model->isCheckDefault && !empty( $model->is_default ) ) return false;
                return Yii::$app->user->can("$area.delete" );
            }
        ];
    }

    /**
     * @param null|string $key
     * @param null|mixed $default
     * @return array|null
     */
    public static function getParams( $key = null, $default = null ) {
        $params = \Yii::$app->params;
        if( is_null( $key ) )
            return $params;

        return ( isset( $params[ $key ] ) )?
            $params[ $key ] : $default;
    }

    /**
     * @param string $key
     * @param bool $checkNamespace
     * @return mixed
     */
    public static function getSettings( string $key, bool $checkNamespace = false, $asModels = false ) {
        $query = Setting::find();
        if( $checkNamespace ) {
            $settings = $query->where(['like', 'key', $key . '.' ])->all();
        } else {
            $settings = [ $query->where(['key' => $key ])->one() ];
        }
        $array = [];
        foreach( $settings as $setting ) {
            $path = explode( '.', $setting->key );
            $array = ( count( $path ) == 1 ) ?
                [ $setting->key => ( $asModels ? $setting : $setting->value ) ] :
                static::_setValue( $path, $array, $setting, $asModels );
        }

        return reset( $array );
    }

    /**
     * @param array $path
     * @param array $array
     * @param Setting $setting
     * @param bool $asModels
     * @return array
     */
    protected static function _setValue( array $path, array $array, Setting $setting, bool $asModels ) {
        $key = array_shift( $path );
        if( empty( $path ) ) {
            try {
                // todo - move in model
                $setting->value = json_decode( $setting->value, true );
            } catch( \Exception $e ) {}
            $value = ( $asModels ? $setting : $setting->value );
        } else
            $value = ( isset( $array[ $key ] ) ? $array[ $key ] : [] );

        $array[ $key ] = $value;

        if( empty( $path ) )
            return $array;

        $subArray = $array[ $key ];
        $array[ $key ] = static::_setValue( $path, $subArray, $setting, $asModels );

        return $array;
    }
}
