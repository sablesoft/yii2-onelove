<?php
namespace backend\widgets;

use Yii;
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
            $newKey = $oldKey ? "$oldKey.$key" : $key;
            $access = $oldKey ? Yii::$app->user->can( $newKey ) : true;
            if( $access )
                $items['items'][] = static::prepareItems( $subConfig, $newKey );
        }

        return $items;
    }
}
