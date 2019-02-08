<?php
namespace backend\controllers;

use common\models\Party;
use backend\models\CrudController;

/**
 * PartyController implements the CRUD actions for Party model.
 */
class PartyController extends CrudController {

    protected $modelClass       = 'common\models\Party';
    protected $searchModelClass = 'common\models\search\PartySearch';

    public function actionClose() {
        /** @var Party $model */
        if( !$model = $this->getModel() )
            return $this->redirect( 'index' );

        if( $model->close() )
            \Yii::$app->session->addFlash(
                'success',
                \Yii::t('app/backend', 'Party closed successful!')
            );

        return $this->redirect(['index']);
    }

}
