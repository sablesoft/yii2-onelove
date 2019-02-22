<?php
namespace backend\controllers;

use yii\web\Response;
use common\models\GalleryPhoto;
use onmotion\gallery\controllers\DefaultController;

class GalleryController extends DefaultController {

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
}