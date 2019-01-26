<?php
namespace frontend\controllers;

use common\models\Ask;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Class AskController
 * @package frontend\controllers
 */
class AskController extends Controller {

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction( $action ) {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction( $action );
    }

    /**
     * @return array
     */
    public function actionValidate() : array {
        $ask = new Ask();
        $request = \Yii::$app->request;
        if( $request->isPost && $ask->load( $request->post() ) ) {
            return ActiveForm::validate( $ask );
        } else
            return [];
    }

    /**
     * @return array
     */
    public function actionCreate() : array {
        $model = new Ask();

        $request = \Yii::$app->getRequest();
        if( $request->isPost && $model->load( $request->post() ) ) {
            $response = [
                'success' => $model->save(),
                'errors' => $model->getErrors()
            ];
        } else {
            $response = [
                'success' => false,
                'errors' => ['Model not loaded!']
            ];
        }

        return $response;
    }
}
