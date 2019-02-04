<?php

namespace backend\controllers;

use Yii;
use common\models\Group;
use common\models\search\GroupSearch;
use backend\models\CrudController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends CrudController {

    protected $modelClass       = 'common\models\Group';
    protected $searchModelClass = 'common\models\search\GroupSearch';

}
