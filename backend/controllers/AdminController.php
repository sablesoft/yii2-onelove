<?php
namespace backend\controllers;

use backend\models\BackendController;

class AdminController extends BackendController {

    /**
     * @return string
     */
    public function actionIndex() {
        return $this->render('index' );
    }

}