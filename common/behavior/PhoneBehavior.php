<?php
namespace common\behavior;

use yii\base\Behavior;
use common\models\User;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\models\Helper;
use yii\helpers\Html;

/**
 * Class PhoneBehavior
 * @package common\behavior
 *
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property string $phoneLabel
 * @property string $phoneLink
 * @property string $phoneHref
 * @property array $maskedPhoneConfig
 */
class PhoneBehavior extends Behavior {

    /** @var ActiveRecord */
    public $owner;
    /** @var array $operators */
    public $operators;
    /**
     * @var array $messengers
     *
     * 'messengers' => [
     *     'messengerA' => [
     *          'mobile'    => 'messengerA.mobile.prefix',
     *          'desktop'   => 'messengerA.desktop.prefix'
     *      ]
     * ]
     */
    public $messengers;

    const PHONE_LENGTH = 12;
    const ATTRIBUTE = 'phone';
    const COUNTRY_CODE = '375';
    const COUNTRY_CODE_PARAM = 'countryCode';
    const SHORT_MASK = '(${1}) ${2}-${3}-${4}';
    const SHORT_PATTERN = '/^(\d{2})(\d{3})(\d{2})(\d{2})/';
    const JS_MASK = ' (99) 999-99-99';
    const PHONE_PREFIX = 'tel:+';

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
        // validate phone operator
        if( !empty( $this->operators ) ) {
            $phone = $this->getShortPhone( $phone );
            foreach( (array) $this->operators as $operator ) {
                if( strpos( $phone, $operator ) === 0 )
                    return;
            }
            $this->owner->addError( $attribute, \Yii::t('app', 'Invalid phone operator' ) );
        }
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
        if( empty( $phone ) && !$this->_check() )
            return '';

        $phone = $phone ? $this->getShortPhone( $phone ) : $this->shortPhone;
        if( empty( $phone ) )
            return '';

        $code = $this->countryCode;

        return "+$code " . preg_replace(
            self::SHORT_PATTERN,
            self::SHORT_MASK,
            $phone
        );
    }

    /**
     * @param null|string $phone
     * @return string
     */
    public function getPhoneLabel( $phone = null ) : string {
        if( empty( $phone ) && !$this->_check() )
            return '';

        $attribute = self::ATTRIBUTE;
        $phone = $phone ?: $this->owner->$attribute;
        if( empty( $phone ) )
            return '';

        $user = User::findOne([ $attribute => $phone ]);
        $username = $user ? $user->username : false;
        $phone = $this->getMaskedPhone( $phone );

        return $username ? $username . " [ $phone ]" : $phone;
    }

    /**
     * @param string|null $phone
     * @return string
     */
    public function getPhoneHref( $phone = null ) : string {
        $attribute = self::ATTRIBUTE;
        $link = $this->_clean( $phone ?: $this->owner->$attribute );

        return self::PHONE_PREFIX . $link;
    }

    /**
     * @param string $messenger
     * @param string|null $phone
     * @return string
     */
    public function getMessengerHref( string $messenger, $phone = null ) : string {
        if( !array_key_exists( $messenger, (array) $this->messengers ) )
            return '#';

        $attribute = self::ATTRIBUTE;
        $link = $this->_clean( $phone ?: $this->owner->$attribute );
        $prefix = $this->messengers[ $messenger ];
        if( is_string( $prefix ) )
            return $prefix . $link;

        if( !isset( $prefix['mobile'] ) && Helper::isMobile() )
            return $prefix['mobile'] . $link;

        return reset( $prefix ) . $link;
    }

    /**
     * @param string|null $phone
     * @return string
     */
    public function getPhoneLink( $phone = null ) :string {
        return Html::a(
            $this->getMaskedPhone( $phone ),
            $this->getPhoneHref( $phone ),
            [
                'title' => \Yii::t('app', 'Call' ),
                'class' => 'phone-link'
            ]
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
        $phone = (string) preg_replace( '/[^0-9]/', '', (string) $phone );
        if( strlen( $phone ) == strlen( $this->countryCode ) )
            $phone = '';

        return $phone;
    }

    /**
     * @return string
     */
    protected function _jsMask() : string {
        return '+' . $this->getCountryCode() . self::JS_MASK;
    }
}
