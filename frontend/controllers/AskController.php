<?php
namespace frontend\controllers;

use yii\base\Model;
use yii\web\Response;
use common\models\Ask;
use yii\web\Controller;
use common\models\Party;
use yii\mail\BaseMailer;
use common\models\Helper;
use common\models\CallForm;
use yii\widgets\ActiveForm;
use yii\base\InvalidConfigException;

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
        $response = [ 'success' => true ];
        try {
            $request = \Yii::$app->getRequest();
            if( $request->isPost && $model->load( $request->post() ) ) {
                if( $model->save() ) {
                    $this->send( $model, 'ask', 'New party ask!' );
                } else
                    $response = [
                        'success' => false,
                        'errors' => $model->getErrors()
                    ];
            } else {
                $response = [
                    'success' => false,
                    'errors' => [ \Yii::t('app','Ask data not loaded!') ]
                ];
            }
        } catch( \Exception $e ) {
            $response = [
                'success' => false,
                'errors' => [ $e->getMessage() ]
            ];
        }

        return $response;
    }

    /**
     * @return array
     */
    public function actionCall() {
        $model = new CallForm();
        $response = [ 'success' => true ];
        try {
            $request = \Yii::$app->getRequest();
            if( $request->isPost && $model->load( $request->post() ) ) {
                $this->send( $model, 'call', 'New call request!' );
            } else
                $response = [
                    'success' => false,
                    'errors' => $model->getErrors()
                ];
        } catch( \Exception $e ) {
            $response = [
                'success' => false,
                'errors' => [ $e->getMessage() ]
            ];
        }

        return $response;
    }

    /**
     * @return array
     */
    public function actionCallValidate() {
        $call = new CallForm();
        $request = \Yii::$app->request;
        if( $request->isPost && $call->load( $request->post() ) ) {
            return ActiveForm::validate( $call );
        } else
            return [];
    }

    /**
     * @param Model $model
     * @param string $view
     * @param string $subject
     * @throws InvalidConfigException
     */
    protected function send( Model $model, string $view, string $subject ) {
        if( !$party = Party::findCurrent() ) {
            $error = \Yii::t('app', 'Nearest party for ask not founded!');
            \Yii::error( $error );

            return;
        }

        if( !$operators = $party->operators )
            return;

        $messages = [];
        /** @var BaseMailer $mailer */
        $mailer = \Yii::$app->mailer;
        $mailer->setView( $this->view );
        foreach( $operators as $operator ) {
            $messages[] = $mailer->compose(
                $view, [ 'model' => $model ]
            )->setSubject( \Yii::t('app', $subject ) )
                ->setFrom( Helper::getSettings('email.manager' ) )
                ->setTo( $operator->email );
        }

        \Yii::$app->mailer->sendMultiple( $messages );
    }
}
