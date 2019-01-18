<?php
namespace backend\controllers;

use backend\models\CrudController;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends CrudController {

    protected $modelClass       = 'common\models\Member';
    protected $searchModelClass = 'common\models\search\MemberSearch';

}
