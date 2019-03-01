<?php
namespace backend\controllers;

use yii\web\Response;
use common\models\Setting;
use common\models\GalleryPhoto;
use onmotion\gallery\models\Gallery;
use onmotion\gallery\models\GallerySearch;
use onmotion\gallery\controllers\DefaultController;

/**
 * Class GalleryController
 * @package backend\controllers
 */
class GalleryController extends DefaultController {

    /**
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new GallerySearch();
        $dataProvider = $searchModel->search( \Yii::$app->request->queryParams );

        return $this->render('index', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            'gallerySelect'     => $this->gallerySelect(),
            'gallerySetting'    => $this->gallerySetting()
        ]);
    }

    /**
     * @return array
     */
    public function actionAdd() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $photoModel = new GalleryPhoto();
        if( $photoModel->load( \Yii::$app->request->post() ) ) {
            if( $photoModel->save() ) {
                \Yii::$app->session->addFlash('success', \Yii::t('app', 'Image added successful'));
            } else
                foreach( (array) $photoModel->getErrors() as $error ) {
                    \Yii::$app->session->addFlash('error', \Yii::t('app', $error ) );
                }
            return [
                'success' => true
            ];
        }

        return [ 'success' => false ];
    }

    /**
     * Displays a single Gallery model.
     * @param string $id
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView( $id ) {

        $photos = GalleryPhoto::find()->where(['gallery_id' => $id])->orderBy('name')->all();

        return $this->render('view', [
            'model' => $this->findModel( $id ),
            'photos' => $photos,
            'photoModel' => new GalleryPhoto([ 'gallery_id' => $id ])
        ]);
    }

    /**
     * @return bool|mixed|Response|null
     */
    public function actionPhotosDelete() {
        $request = \Yii::$app->request;
        $photoIds = $request->post('ids'); // Array or selected records primary keys
        $photoModels = GalleryPhoto::findAll( $photoIds );
        if( empty( $photoModels ) ) return null;
        try {
            GalleryPhoto::deleteAll(['photo_id' => $photoIds]);
        } catch( \Exception $e) {
            \Yii::$app->session->addFlash('error', $e->getMessage() );
        }

        if ($request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return true;
        } else
            return $this->redirect(['index']);

    }

    /**
     * @return array
     */
    protected function gallerySelect() {
        return \yii\helpers\ArrayHelper::map(
            Gallery::find()->all(), 'gallery_id', 'name'
        );
    }

    /**
     * @return Setting
     */
    protected function gallerySetting() {
        $setting = Setting::findOne(['key' => Setting::SECTION_GALLERY ]) ?:
            new Setting([
                'label' => 'Selected Gallery',
                'description' => \Yii::t('app/backend', 'Selected gallery for show in landing' ),
                'key' => Setting::SECTION_GALLERY,
                'value' => null
            ]);

        if( $setting->load( \Yii::$app->request->post() ) )
            if( !$setting->save() )
                foreach( $setting->getErrors() as $error )
                    \Yii::$app->session->addFlash('error', reset( $error ) );

        return $setting;
    }
}
