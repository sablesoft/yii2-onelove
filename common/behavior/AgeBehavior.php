<?php
namespace common\behavior;

use yii\base\Model;
use yii\base\Behavior;
use common\models\Helper;

/**
 * Class AgeBehavior
 * @package common\behavior
 *
 * @property int $minAge
 * @property int $maxAge
 * @property string $ageLabel
 * @property array $ageCondition
 */
class AgeBehavior extends Behavior {

    const MIN_AGE = 16;
    const MAX_AGE = 70;
    const ATTRIBUTE = 'age';

    /** @var Model $owner */
    public $owner;
    public $field = self::ATTRIBUTE;
    public $attribute = self::ATTRIBUTE;

    /** @var array */
    protected $settings;

    protected $operators = [ '>', '<' ];

    /**
     * @return int
     */
    public function getMinAge() : int {
        $settings = $this->getSettings();
        return is_int( $settings['min'] )? $settings['min'] : self::MIN_AGE;
    }

    /**
     * @return int
     */
    public function getMaxAge() : int {
        $settings = $this->getSettings();
        return is_int( $settings['min'] )? $settings['max'] : self::MAX_AGE;
    }


    /**
     * @return string
     */
    public function getAgeLabel() : string {
        if( !$word = $this->_ageLabel() )
            return '';

        $message = "{0} $word";
        $attribute = $this->attribute;

        return \Yii::t('app', $message, $this->owner->$attribute );
    }

    /**
     * @return array
     */
    public function getAgeCondition( $field = null, $age = null ) {

        $attribute = $this->attribute;

        if( is_null( $field ) )
            $field = $this->field;
        if( is_null( $age ) )
            $age = $this->owner->$attribute;

        $condition = [ $field => $age ];
        if( empty( $age ) )
            return $condition;

        $age = (string) $age;
        $firstChar = $age[0];
        if( is_numeric( $firstChar ) )
            return $condition;

        $age = (int) trim( substr( $age, 1 ) );
        if( !is_int( $age ) || !in_array( $firstChar, $this->operators ) )
            return [ $field => null ];

        return [ $firstChar, $field, $age ];
    }

    /**
     * @return string
     */
    protected function _ageLabel() : string {
        $age = $this->owner->age;
        if( !$age )
            return '';

        $num = $age > 100 ? substr( $age, -2 ) : $age;
        if( $num >= 5 && $num <= 14 ) {
            return 'ages';
        } else {
            $num = substr( $age, -1 );
            if( $num == 0 || ( $num >= 5 && $num <= 9 ) ) return 'ages';
            if( $num == 1 ) return 'year';
            if( $num >= 2 && $num <= 4 ) return 'years';
        }
        return '';
    }

    /**
     * @return array|null
     */
    protected function getSettings() {
        return $this->settings ?:
            $this->settings = Helper::getSettings('age', true );
    }
}
