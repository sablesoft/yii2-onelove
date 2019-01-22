<?php
namespace common\models\query;

use common\models\Party;

/**
 * This is the ActiveQuery class for [[Party]].
 *
 * @see Party
 */
class PartyQuery extends BaseQuery {

    /**
     * @return BaseQuery
     */
    public function active() {
        return parent::active()->andWhere([ 'closed' => 0 ]);
    }
}
