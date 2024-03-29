<?php
namespace frontend\controllers;

use Yii;
use common\models\Ask;
use yii\web\Controller;
use common\models\Party;
use common\models\Helper;
use common\models\CallForm;
use backend\models\Statistic;
use common\models\GalleryPhoto;
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
     * Landing page.
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
        $ask = new Ask();
        $call = new CallForm();
        /** @var Party $party */
        $party = Party::findCurrent();
        $party = $party ?: new Party();
        $this->layout = 'landing/main.tpl';
        LandingAsset::register( $this->view );
        $modalsSettings = Helper::getSettings('modal', true );
        $successModal = [
            'id' => 'askSuccess',
            'header' => Yii::t('app/frontend', $modalsSettings['success']['header'] ),
            'message' => Yii::t('app/frontend', $modalsSettings['success']['message'] ),
        ];
        $failModal = [
            'id' => 'askFail',
            'header' => Yii::t('app/frontend', $modalsSettings['fail']['header'] ),
            'message' => Yii::t('app/frontend', $modalsSettings['fail']['message'] ),
        ];
        // load public gallery items
        $galleryItems = GalleryPhoto::findSelectedItems();

        $commentItems = Helper::getParams('comments');

        // add landing browsing in statistic: todo - make by ajax after page load
        Statistic::addBrowsing();

        return $this->render(
            'index.tpl',
            compact('ask', 'party', 'call',
                'successModal', 'failModal',
                'galleryItems', 'commentItems'
            )
        );
    }
}
