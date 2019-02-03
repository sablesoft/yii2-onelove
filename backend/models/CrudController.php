<?php
namespace backend\models;

use Yii;
use yii\web\Controller;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use common\interfaces\SearchInterface;

/**
 * PlaceController implements the CRUD actions for Place model.
 */
class CrudController extends Controller {

    protected $modelClass;
    protected $searchModelClass;

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST']
                ]
            ]
        ];
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex() {
        $class = $this->searchModelClass;
        /** @var ActiveRecord|SearchInterface $searchModel */
        $searchModel = new $class();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Place model.
     * @param integer $id
     * @return mixed
     */
    public function actionView( $id ) {
        if( !$model = $this->findModel( $id ) )
            return $this->redirect( 'index' );

        return $this->render('view', [
            'model' => $this->findModel( $id )
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $class = $this->modelClass;
        /** @var ActiveRecord $model */
        $model = new $class();

        if( $model->load( Yii::$app->request->post() ) && $model->save() )
            return $this->redirect([ 'view', 'id' => $model->id ]);

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate( $id ) {
        if( !$model = $this->findModel( $id ) )
            return $this->redirect( 'index' );

        if( $model->load( Yii::$app->request->post() ) && $model->save() )
            return $this->redirect([ 'view', 'id' => $model->id ]);

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete( $id ) {
        if( !$model = $this->findModel( $id ) )
            return $this->redirect( 'index' );

        try {
            $model->delete();
        } catch ( StaleObjectException $e ) {
            Yii::$app->session->addFlash('error', $e->getMessage() );
        } catch ( \Throwable $e ) {
            Yii::$app->session->addFlash('error', $e->getMessage() );
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActiveRecord|null the loaded model
     */
    protected function findModel( $id ) {
        /** @var ActiveRecord $class */
        $class = $this->modelClass;
        if( ( $model = $class::findOne( $id ) ) !== null )
            return $model;

        $error = \Yii::t('yii', 'The requested page does not exist.');
        Yii::$app->session->addFlash('error', $error );

        return null;
    }
}
