<?php

namespace backend\controllers;

use backend\models\CrudController;

/**
 * StatisticController implements the CRUD actions for Statistic model.
 */
class StatisticController extends CrudController {

    protected $modelClass       = 'backend\models\Statistic';
    protected $searchModelClass = 'backend\models\search\StatisticSearch';
}
