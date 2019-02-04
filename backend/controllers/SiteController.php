<?php
namespace backend\controllers;

use common\models\Helper;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [ 'operator' ]
                    ]
                ],
                'denyCallback' => function( $rule, $action ) {
                    Yii::$app->session->setFlash('yii', 'Access denied');
                    $redirect = Yii::$app->user->getIsGuest() ?
                        '/login' : Helper::getSettings('domain.front');

                    return $action->controller->redirect( $redirect );
                },
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $this->view->title = Yii::t('app/backend', 'Admin Panel');
        return $this->render('index.tpl');
    }
}
