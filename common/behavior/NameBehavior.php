<?php
namespace common\behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class NameBehavior
 * @package common\behavior
 */
class NameBehavior extends Behavior {

    /** @var ActiveRecord */
    public $owner;

    const LATIN_PATTERN = '/^[\p{Latin}\ ]+$/u';
    const CYRILLIC_PATTERN = '/^[\p{Cyrillic}\ ]+$/u';

    /**
     * @param string $attribute
     * @param $params
     */
    public function validateName( string $attribute, $params ) {
        $name = trim( $this->owner->$attribute );
        if( !preg_match( self::LATIN_PATTERN, $name ) &&
            !preg_match( self::CYRILLIC_PATTERN, $name ) )
            $this->owner->addError(
                $attribute,
                \Yii::t('app/error', 'Invalid characters in name.')
            );
    }
}
