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
}
