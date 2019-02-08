<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Ticket]].
 *
 * @see \common\models\Ticket
 */
class TicketQuery extends \yii\db\ActiveQuery {

    /**
     * @return TicketQuery
     */
    public function active() {
        return $this->andWhere('[[is_blocked]]=0');
    }

    /**
     * @param bool $closed
     * @return TicketQuery
     */
    public function closed( $closed = true ) {
        $closed = $closed ? 1 : 0;
        return $this->andWhere("[[closed]]=$closed");
    }

    /**
     * @param bool $visited
     * @return TicketQuery
     */
    public function visited( $visited = true ) {
        $visited = $visited ? 1 : 0;
        return $this->andWhere("[[visited]]=$visited");
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Ticket[]|array
     */
    public function all( $db = null ) {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Ticket|array|null
     */
    public function one( $db = null ) {
        return parent::one( $db );
    }
}
