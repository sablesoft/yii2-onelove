<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\Statistic]].
 *
 * @see \backend\models\Statistic
 */
class StatisticQuery extends \yii\db\ActiveQuery {

    /**
     * @return StatisticQuery
     */
    public function active() {
        return $this->byDate()->byOperator();
    }

    /**
     * @param null|integer $id
     * @return $this|StatisticQuery
     */
    public function byOperator( $id = null ) {
        if( !$id )
            $id = \Yii::$app->user->getId();
        if( !$id ) // todo
            return $this;
        return $this->andWhere(['operator_id' => $id ]);
    }

    /**
     * @param null|string $date
     * @return StatisticQuery
     */
    public function byDate( $date = null ) {
        if( !$date )
            $date = date('Y-m-d');
        return $this->andWhere(['date' => $date ]);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\Statistic[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\Statistic|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }
}
