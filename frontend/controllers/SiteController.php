<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Party;
use frontend\assets\LandingAsset;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
//        Yii::$app->vueManager->register([
//            'id' => 'landing',
//            'jsName'  => 'vueLanding',
//            'data' => [
//                'h1' => 'Vue Test'
//            ],
//        'created' =>
//            new JsExpression( "function() { console.log('Vue created!')}" ),
//        'computed' => '@yourAlias/path/to/computed.js',
//    ]   );
        $this->view->title = Yii::$app->name; // todo landing.title setting
        $this->view->registerLinkTag([
            'rel' => 'stylesheet',
            'crossorigin'   => 'anonymous',
            'integrity' => 'sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP',
            'href' => 'https://use.fontawesome.com/releases/v5.6.1/css/all.css']);
        LandingAsset::register( $this->view );
        $this->layout = 'landing/main.tpl';
        /** @var Party $party */
        $party = Party::findNearest();
        $party = $party ?: new Party();
        return $this->render('index.tpl', [
            'party' => $party
        ]);
    }
}
