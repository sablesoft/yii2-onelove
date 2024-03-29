<?php
namespace frontend\widgets;

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
                'label' => Yii::t('yii', 'Signup'),
                'url' => ['/signup']
            ];
            $menuItems[] = [
                'label' => Yii::t('yii', 'Login'),
                'url' => ['/login']
            ];
        } else {
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
}
