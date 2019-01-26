<?php
namespace common\behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class PhoneBehavior
 * @package common\behavior
 *
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 */
class PhoneBehavior extends Behavior {

    /** @var ActiveRecord */
    public $owner;

    const PHONE_LENGTH = 12;
    const ATTRIBUTE = 'phone';
    const COUNTRY_CODE = '375';
    const COUNTRY_CODE_PARAM = 'countryCode';
    const SHORT_MASK = '(${1}) ${2}-${3}-${4}';
    const SHORT_PATTERN = '/^(\d{2})(\d{3})(\d{2})(\d{2})/';
    const JS_MASK = ' (99) 999-99-99';

    /**
     * @return array
     */
    public function events() {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'cleanPhone',
            ActiveRecord::EVENT_BEFORE_INSERT => 'cleanPhone',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'cleanPhone'
        ];
    }

    /**
     * @param string $attribute
     * @param $params
     */
    public function validatePhone( string $attribute, $params ) {
        $phone = $this->owner->$attribute;
        if( strlen( $phone ) !== self::PHONE_LENGTH )
            $this->owner->addError( $attribute, \Yii::t('app', 'Phone should contain {0} numbers', self::PHONE_LENGTH ) );
    }

    /**
     * @return bool
     */
    public function cleanPhone() : bool {
        $attribute = self::ATTRIBUTE;
        if( !$this->_check( $attribute ) )
            return false;

        $this->owner->$attribute = $this->_clean( $this->owner->$attribute );

        return true;
    }

    /**
     * @return string
     */
    public function getCountryCode() : string {
        return !empty( \Yii::$app->params[ static::COUNTRY_CODE_PARAM ] ) ?
            \Yii::$app->params[ static::COUNTRY_CODE_PARAM ] : static::COUNTRY_CODE;
    }

    /**
     * @return string
     */
    public function getShortPhone( $phone = null ) : string {
        $attribute = self::ATTRIBUTE;
        if( is_null( $phone ) && !$this->_check( $attribute ) )
            return '';

        $phone = $this->_clean( $phone ?: $this->owner->$attribute );
        if( strpos( $phone, $this->countryCode ) !== 0 )
            return $phone;

        return substr( $phone, strlen( $this->countryCode ) );
    }

    /**
     * @return string
     */
    public function getMaskedPhone( $phone = null ) : string {
        if( is_null( $phone ) && !$this->_check() )
            return '';

        $phone = $phone ? $this->getShortPhone( $phone ) : $this->shortPhone;
        $code = $this->countryCode;

        return "+$code " . preg_replace(
            self::SHORT_PATTERN,
            self::SHORT_MASK,
            $phone
        );
    }

    /**
     * @param array $config
     * @return array
     */
    public function getMaskedPhoneConfig( array $config = []) : array {
        return ArrayHelper::merge([
            'mask' => $this->_jsMask(),
            'options' => [
                'value' => $this->shortPhone,
                'class' => 'form-control'
            ]
        ], $config );
    }

    /**
     * @param string|null $attribute
     * @return bool
     */
    protected function _check( $attribute  = self::ATTRIBUTE ) : bool {
        if( !$this->owner->canGetProperty( $attribute ) ||
            !$this->owner->canSetProperty( $attribute ) ) {
            \Yii::error( \Yii::t('app', 'Model not have phone attribute!' ) );

            return false;
        }

        return true;
    }

    /**
     * @param mixed $phone
     * @return string
     */
    protected function _clean( $phone ) : string {
        return (string) preg_replace( '/[^0-9]/', '', (string) $phone );
    }

    /**
     * @return string
     */
    protected function _jsMask() : string {
        return '+' . $this->getCountryCode() . self::JS_MASK;
    }
}
