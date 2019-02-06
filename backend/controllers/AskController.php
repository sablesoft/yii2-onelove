<?php

namespace backend\controllers;

use common\models\Ask;
use backend\models\CrudController;
use yii\db\StaleObjectException;

/**
 * AskController implements the CRUD actions for Ask model.
 */
class AskController extends CrudController {

    protected $modelClass       = 'common\models\Ask';
    protected $searchModelClass = 'common\models\search\AskSearch';

    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionMake() {
        $class = $this->modelClass;
        /** @var Ask $ask */
        $ask = new $class();

        if( $ask->load( \Yii::$app->request->post() ) && $ask->make() )
            return $this->redirect([ 'view', 'id' => $ask->id ]);

        return $this->render('make', [
            'model' => $ask
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAccept( $id ) {
        if( !$model = $this->findModel( $id ) )
            return $this->redirect( 'index' );

        if( $model->accept() )
            \Yii::$app->session->addFlash(
                'success',
                \Yii::t('app/backend', 'Ask accepted successful!')
            );

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionMember( $id ) {
        if( !$model = $this->findModel( $id ) )
            return $this->redirect( 'index' );

        try {
            $model->member();
            \Yii::$app->session->addFlash(
                'success',
                \Yii::t('app/backend', 'Member saved successful!')
            );
        } catch ( \Exception $e ) {
            \Yii::$app->session->addFlash(
                'error',
                \Yii::t('yii', $e->getMessage() )
            );
        }

        return $this->redirect(['index']);
    }

    /**
     * @return mixed|\yii\web\Response
     */
    public function actionReject() {
        /** @var Ask $model */
        if( !$model = $this->getModel() )
            return $this->redirect( 'index' );

        try {
            $model->reject();
        } catch ( \Throwable $e ) {
            \Yii::$app->session->addFlash('error', $e->getMessage() );
        }

        return $this->redirect(['index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionRejectAll() {
        if( Ask::rejectAll() )
            \Yii::$app->session->addFlash(
                'success',
                \Yii::t('app/backend', 'All asks rejected successful!')
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
                \Yii::t('app/backend', 'All asks accepted successful!')
            );

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return \yii\db\ActiveRecord|Ask|null
     */
    protected function findModel( $id ) {
        return parent::findModel( $id );
    }
}
