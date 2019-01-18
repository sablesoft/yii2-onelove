<?php
namespace backend\controllers;

use backend\models\CrudController;

/**
 * PartyController implements the CRUD actions for Party model.
 */
class PartyController extends CrudController {

    protected $modelClass       = 'common\models\Party';
    protected $searchModelClass = 'common\models\search\PartySearch';

}
