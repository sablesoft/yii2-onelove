<?php

namespace backend\controllers;

use common\models\Ask;
use backend\models\CrudController;

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
        $this->findModel( $id )->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionRejectAll() {
        Ask::deleteAll();

        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAccept( $id ) {
        if( $this->findModel( $id )->accept() )
            \Yii::$app->session->addFlash(
                'success',
                \Yii::t('app', 'Ask accepted successful!')
            );

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionAcceptAll() {
        if( Ask::acceptAll() )
            \Yii::$app->session->addFlash(
                'success',
                \Yii::t('app', 'All asks accepted successful!')
            );

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return \yii\db\ActiveRecord|Ask
     * @throws \yii\web\NotFoundHttpException
     */
    protected function findModel( $id ) {
        return parent::findModel( $id );
    }
}
