<?php
namespace backend\controllers;

use backend\models\CrudController;

/**
 * PriceController implements the CRUD actions for Price model.
 */
class PriceController extends CrudController {

    protected $modelClass       = 'common\models\Price';
    protected $searchModelClass = 'common\models\search\PriceSearch';

}
