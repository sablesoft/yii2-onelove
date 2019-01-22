<?php
namespace common\models\query;

use yii\db\ActiveQuery;

class BaseQuery extends ActiveQuery {

    /**
     * @return BaseQuery
     */
    public function active() {
        return $this->andWhere(['is_blocked' => 0]);
    }

    /**
     * {@inheritdoc}
     * @return BaseQuery[]|array
     */
    public function all( $db = null ) {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return BaseQuery|array|null
     */
    public function one( $db = null ) {
        return parent::one( $db );
    }
}
