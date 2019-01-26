<?php
namespace frontend\controllers;

use Yii;
use common\models\Ask;
use common\models\Helper;
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
        $this->view->title = Yii::$app->name; // todo landing.title setting
        $this->view->registerLinkTag([
            'rel' => 'stylesheet',
            'crossorigin'   => 'anonymous',
            'integrity' => 'sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP',
            'href' => 'https://use.fontawesome.com/releases/v5.6.1/css/all.css']);
        $ask = new Ask(['sex' => 1]);
        /** @var Party $party */
        $party = Party::findNearest();
        $party = $party ?: new Party();
        $this->layout = 'landing/main.tpl';
        LandingAsset::register( $this->view );
        $modalsSettings = Helper::getSettings('modal', true );
        $successModal = [
            'id' => 'askSuccess',
            'header' => !empty( $modalsSettings['success']['header'] )?
                $modalsSettings['success']['header'] :
                Yii::t('app', 'Ask sent'),
            'message' => !empty( $modalsSettings['success']['message'] )?
                $modalsSettings['success']['message'] :
                Yii::t('app', 'Our operator will contact you shortly.'),
        ];
        $failModal = [
            'id' => 'askFail',
            'header' => !empty( $modalsSettings['fail']['header'] )?
                $modalsSettings['success']['fail'] :
                Yii::t('app', 'Oops!'),
            'message' => !empty( $modalsSettings['fail']['message'] )?
                $modalsSettings['fail']['message'] :
                Yii::t('app', 'Something went wrong. Please try later.'),
        ];

        return $this->render(
            'index.tpl',
            compact('ask', 'party', 'successModal', 'failModal')
        );
    }
}
