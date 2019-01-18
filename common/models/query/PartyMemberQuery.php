<?php
namespace common\models\query;

use common\models\PartyMember;

/**
 * This is the ActiveQuery class for [[PartyMember]].
 *
 * @see PartyMember
 */
class PartyMemberQuery extends \yii\db\ActiveQuery {

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PartyMember[]|array
     */
    public function all( $db = null ) {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return PartyMember|array|null
     */
    public function one( $db = null ) {
        return parent::one( $db );
    }
}
