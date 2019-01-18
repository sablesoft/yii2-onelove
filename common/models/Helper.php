<?php

namespace common\models;

/**
 * Class Helper
 * @package common\models
 */
class Helper {

    /**
     * @return string
     */
    public static function pageId() : string {
        $id = \Yii::$app->id;
        $id .= '_' . \Yii::$app->controller->id;
        $id .= '_' . \Yii::$app->controller->action->id;

        return $id;
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
