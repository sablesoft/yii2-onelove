<?php

namespace backend\controllers;

use backend\models\CrudController;
use common\models\Ask;

/**
 * AskController implements the CRUD actions for Ask model.
 */
class AskController extends CrudController {

    protected $modelClass       = 'common\models\Ask';
    protected $searchModelClass = 'common\models\search\AskSearch';

    /**
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionReject( $id ) {
        $this->findModel( $id )->reject();

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionRejectAll() {
        Ask::deleteAll();

        return $this->redirect(['index']);
    }

    public function actionAccept( $id ) {
        $this->findModel( $id )->accept();

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAcceptAll() {
        Ask::acceptAll();

        return $this->redirect(['index']);
    }

}
