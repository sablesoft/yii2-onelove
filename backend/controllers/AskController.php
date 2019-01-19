<?php

namespace backend\controllers;

use backend\models\CrudController;

/**
 * AskController implements the CRUD actions for Ask model.
 */
class AskController extends CrudController {

    protected $modelClass       = 'common\models\Ask';
    protected $searchModelClass = 'common\models\search\AskSearch';

}
