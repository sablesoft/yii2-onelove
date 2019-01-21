<?php
namespace backend\models;

use Yii;
use yii\base\InlineAction;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BackendController extends Controller {

    /**
     * @param InlineAction $action
     * @return bool
     * @throws ForbiddenHttpException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction( $action ) : bool {
        $permission = $this->id . "." . $action->id;
        If( !Yii::$app->user->can( $permission ) )
            throw new ForbiddenHttpException( Yii::t('yii', 'Access denied') );

        return parent::beforeAction( $action );
    }

}