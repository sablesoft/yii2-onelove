<?php
namespace common\models;

use common\behavior\PhoneBehavior;
use yii\helpers\ArrayHelper;

/**
 * User model
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 * @method string getMaskedPhone( string $phone )
 */
class User extends \dektrium\user\models\User {

    /**
     * @return array
     */
    public function behaviors() {
        return array_merge( parent::behaviors(), [
            PhoneBehavior::class
        ]);
    }

    /**
     * @return array
     */
    public function scenarios() {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'phone';
        $scenarios['update'][]   = 'phone';
        $scenarios['register'][] = 'phone';
        return $scenarios;
    }

    /**
     * @return array
     */
    public function rules() {
        $rules = parent::rules();
        // add some rules
        $rules['phoneLength']   = ['phone', 'validatePhone'];

        return $rules;
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->username . ' ( ' .
            $this->email . ' )';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return array_merge(
            parent::attributeLabels(),
            [
                'phone' => \Yii::t('app', 'Phone')
            ]
        );
    }

    /**
     * @return array
     */
    public static function getDropDownList( $config = [], $models = null ) : array {
        // prepare items:
        if( is_null( $models ) ) {
            $query = static::find();
            $where = !empty( $config['where'] )? $config['where'] : false;
            if( is_array( $where ) )
                $query = $query->where( $where );
            $models = $query->all();
        }
        $from = !empty( $config['from'] )? $config['from'] : 'id';
        $to = !empty( $config['to'] )? $config['to'] : 'label';
        $items = ArrayHelper::map( $models, $from, $to );
        // prepare params:
        $params = [];
        if( !empty( $config['selected'] ) ) {
            $selected = static::find()->where(['is_default' => 1])->one();
            if( $selected->id )
                $params = [
                    'options' => [
                        $selected->id => [ 'Selected' => true ]
                    ]
                ];
        }
        if( isset( $config['prompt'] ) )
            $params['prompt'] = $config['prompt'];

        return [ $items, $params ];
    }

    /**
     * @param string|null $role
     * @return array
     */
    public static function findPhonesList( $role = null ) : array {
        $user = new User();
        $list = static::findRoleList( $role, 'phone' );
        $items = [];
        foreach( $list[0] as $phone => $name )
            if( $phone )
                $items[ $phone ] = $user->getMaskedPhone( $phone ) . " ( $name )";
        $list[0] = $items;

        return $list;
    }

    /**
     * @return array
     */
    public static function findRoleList(
        $role = null,
        string $from = 'id',
        string $to = 'username' ) : array {
        $users = static::find()->byRole( $role )->all();

        return static::getDropDownList( ['from' => $from, 'to' => $to  ], $users );
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\UserQuery( get_called_class() );
    }
}
