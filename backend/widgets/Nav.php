<?php
namespace backend\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\interfaces\NavInterface;

/**
 * Class Nav
 * @package common\widgets
 */
class Nav extends \yii\bootstrap\Nav implements NavInterface {

    /**
     * @return array
     */
    public static function menuItems() : array {
        $menuItems = [];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = [
                'label' => Yii::t('yii', 'Login'),
                'url' => ['/login']
            ];
        } else {
            $rawItems = Yii::$app->params['nav'];
            $menuItems = static::prepareItems( (array) $rawItems );
            $menuItems = $menuItems['items'];
            $menuItems[] = '<li>'
                . Html::beginForm(['/logout'], 'post')
                . Html::submitButton(
                    Yii::t('yii', 'Logout')
                    .' (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }

        return $menuItems;
    }

    protected static function prepareItems( $config, $oldKey = null ) {
        $items = [];
        foreach( (array) $config as $key => $subConfig ) {
            if( $key === '_menu' ) {
                $items = $subConfig;
                foreach( $items as $field => $value )
                    if( $field == 'label')
                        $items[ $field ] = Yii::t('app', $value );
                continue;
            }
            if( !static::checkAccess( $subConfig, $key, $oldKey ) )
                continue;
            $items['items'][] = static::prepareItems( $subConfig, trim( "$oldKey.$key", '.' ) );
        }

        return $items;
    }

    /**
     * @param array $config
     * @param string $key
     * @param null|string $oldKey
     * @return bool
     */
    protected static function checkAccess( array &$config, string $key, $oldKey = null ) {
        $default = $oldKey ?  "$oldKey.$key" : "menu.$key";
        $permission = ArrayHelper::remove( $config, '_access', $default );

        return Yii::$app->user->can( $permission );
    }
}
