<?php
namespace common\models\query;

use common\models\Party;

/**
 * This is the ActiveQuery class for [[Party]].
 *
 * @see Party
 */
class PartyQuery extends \yii\db\ActiveQuery {

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Party[]|array
     */
    public function all( $db = null ) {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return Party|array|null
     */
    public function one( $db = null ) {
        return parent::one( $db );
    }
}
