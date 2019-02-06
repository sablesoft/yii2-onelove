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
    public function actionMake() : array {
        $model = new Ask();
        $response = [ 'success' => true ];
        try {
            $request = \Yii::$app->getRequest();
            if( $request->isPost && $model->load( $request->post() ) ) {
                if( $model->make() ) {
                    $subject = \Yii::t('app/frontend', 'New party ask!' );
                    $this->send( $model, 'ask', $subject );
                } else
                    $response = [
                        'success' => false,
                        'errors' => $model->getErrors()
                    ];
            } else {
                $response = [
                    'success' => false,
                    'errors' => [ \Yii::t('app/error','Ask data not loaded!') ]
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
                $subject = \Yii::t('app/frontend', 'New call request!' );
                $this->send( $model, 'call', $subject );
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
            $error = \Yii::t('app/error', 'Nearest party for ask not founded!');
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
            )->setSubject( \Yii::t('app/frontend', $subject ) )
                ->setFrom( Helper::getSettings('email.manager' ) )
                ->setTo( $operator->email );
        }

        \Yii::$app->mailer->sendMultiple( $messages );
    }
}
