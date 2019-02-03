<?php
namespace common\behavior;

use common\models\User;
use yii\behaviors\AttributeBehavior;

/**
 * Class OwnerBehavior
 * @package common\behavior
 *
 * @property User|null $ownerUser
 */
class OwnerBehavior extends AttributeBehavior {

    /**
     * @param int $userId
     */
    public function isOwner( int $userId ) : bool {
        if( empty( $this->owner->owner_id ) )
            return false;

        return $this->owner->owner_id == $userId;
    }

    /**
     * @return User|null
     */
    public function getOwnerUser() {
        if( empty( $this->owner->owner_id ) )
            return null;

        return User::findOne( $this->owner->owner_id );
    }

}