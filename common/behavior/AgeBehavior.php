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
 */
class AgeBehavior extends Behavior {

    const MIN_AGE = 16;
    const MAX_AGE = 70;

    /** @var Model $owner */
    public $owner;

    public function getMinAge() {
        return Helper::getSettings('min_age') ?: self::MIN_AGE;
    }

    public function getMaxAge() {
        return Helper::getSettings('max_age') ?: self::MAX_AGE;
    }


    /**
     * @return string
     */
    public function getAgeLabel() : string {
        if( !$word = $this->_ageLabel() )
            return '';
        $message = "{0} $word";

        return \Yii::t('app', $message, $this->owner->age );
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
}
