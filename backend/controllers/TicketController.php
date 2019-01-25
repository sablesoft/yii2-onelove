<?php
namespace backend\controllers;

use backend\models\CrudController;

/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends CrudController {

    protected $modelClass       = 'common\models\Ticket';
    protected $searchModelClass = 'common\models\search\TicketSearch';

}
