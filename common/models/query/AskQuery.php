<?php
namespace common\models\query;

use common\models\Ask;

/**
 * This is the ActiveQuery class for [[Ask]].
 *
 * @see Ask
 */
class AskQuery extends \yii\db\ActiveQuery {

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ask[]|array
     */
    public function all( $db = null ) {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return Ask|array|null
     */
    public function one( $db = null ) {
        return parent::one( $db );
    }
}
