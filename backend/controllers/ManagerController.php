<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ManagerController extends Controller {

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
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    public function actionIndex() {
        return $this->render('index.tpl');
    }

    public function actionAsk() {
        return $this->render('ask');
    }

    public function actionMember() {
        return $this->render('member');
    }

    public function actionParty() {
        return $this->render('party');
    }

    public function actionPrice() {
        return $this->render('price');
    }

}