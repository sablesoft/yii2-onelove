<?php
namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Price]].
 *
 * @see \common\models\Price
 */
class UserQuery extends \yii\db\ActiveQuery {

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param string $role
     * @return UserQuery
     */
    public function byRole( string $role ) : UserQuery {
        $ids = \Yii::$app->authManager->getUserIdsByRole( $role );

        return $this->andWhere(['id' => $ids ]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Price[]|array
     */
    public function all( $db = null ) {
        return parent::all( $db );
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Price|array|null
     */
    public function one( $db = null ) {
        return parent::one( $db );
    }
}
