<?php
namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Price]].
 *
 * @see \common\models\Price
 */
class UserQuery extends \yii\db\ActiveQuery {

    protected $_businessRoles = [ 'admin', 'manager', 'operator'];

    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @param string|null $role
     * @return UserQuery
     */
    public function byRole( $role = null ) : UserQuery {
        if( !empty( $role ) ) {
            $ids = \Yii::$app->authManager->getUserIdsByRole( $role );
        } else {
            $ids = [];
            foreach( $this->_businessRoles as $role ) {
                $roleIds = \Yii::$app->authManager->getUserIdsByRole( $role );
                $ids = array_merge( $ids, $roleIds );
            }
        }

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
