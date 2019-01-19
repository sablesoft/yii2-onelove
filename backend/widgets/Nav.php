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
                'url' => ['/site/login']
            ];
        } else {
            $menuItems = [
                [
                    'label' => Yii::t('app', 'Asks'),
                    'url'   => ['/ask']
                ],
                [
                    'label' => Yii::t('app', 'Parties'),
                    'url'   => ['/party']
                ],
                [
                    'label' => Yii::t('app', 'Prices'),
                    'url'   => ['/price']
                ],
                [
                    'label' => Yii::t('app', 'Places'),
                    'url'   => ['/place']
                ],
                [
                    'label' => Yii::t('app', 'Members'),
                    'url'   => ['/member']
                ]
            ];
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post')
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
