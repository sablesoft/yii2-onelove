<?php
namespace backend\controllers;

use yii\web\Controller;

class AdminController extends Controller {

    /**
     * @return string
     */
    public function actionIndex() {
        return $this->render('index' );
    }

}