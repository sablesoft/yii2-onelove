<?php
namespace backend\controllers;

use backend\models\CrudController;

/**
 * PlaceController implements the CRUD actions for Place model.
 */
class PlaceController extends CrudController {

    protected $modelClass       = 'common\models\Place';
    protected $searchModelClass = 'common\models\search\PlaceSearch';

}
