<?php
namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Class LandingAsset
 * @package frontend\assets
 */
class LandingAsset extends AssetBundle {
    public $basePath = '@webroot/landing';
    public $baseUrl = '@web/landing';
    public $css = [
        'css/normalize.css',
        'css/styles.css'
    ];
    public $js = [
        'js/jquery.maskedinput.js',
        'js/common.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];

    public function init() {
        parent::init();
        unset( \Yii::$app->view->assetBundles['frontend\assets\AppAsset'] );
    }
}
