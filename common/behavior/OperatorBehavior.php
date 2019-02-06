<?php
namespace common\behavior;

use common\models\User;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

class OperatorBehavior extends AttributeBehavior {

    public $operatorField;

    public function init() {
        parent::init();
        if( !$this->attributes )
            $this->attributes = [
                ActiveRecord::EVENT_BEFORE_VALIDATE => [ $this->operatorField ],
                ActiveRecord::EVENT_BEFORE_INSERT   => [ $this->operatorField ],
                ActiveRecord::EVENT_BEFORE_UPDATE   => [ $this->operatorField ]
            ];
    }

    /**
     * @return string
     */
    public function getOperatorLabel() :string {
        try {
            if( !$operator = $this->owner->operator ) return '';
        } catch( \Exception $e ) {
            return '';
        }

        return $operator->username;
    }

    /**
     * @return array
     */
    public function getOperatorUrl() : array {
        $field = $this->operatorField;
        return [ '/user/profile/show', 'id' => $this->owner->$field ];
    }

    public function getValue( $event ) {
        return (int) \Yii::$app->user->getId() ?: $this->getAdminId();
    }

    /**
     * @return int
     */
    private function getAdminId() {
        return ( $admin = User::findOne(['username' => 'admin' ]) )?
            $admin->id : 1;
    }
}