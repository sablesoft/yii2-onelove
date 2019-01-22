<?php
namespace common\models;

use yii\helpers\ArrayHelper;

/**
 * User model
 *
 */
class User extends \dektrium\user\models\User {

    const DEFAULT_ROLE = 'operator';

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
        $rules['phoneLength']   = ['phone', 'string', 'max' => 30];

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
     * @param string $role
     * @return array
     */
    public static function findPhonesList( string $role = self::DEFAULT_ROLE ) : array {
        $list = static::findRoleList( $role, 'phone' );
        $items = [];
        foreach( $list[0] as $phone => $name )
            if( $phone )
                $items[ $phone ] = $phone . " ( $name )";
        $list[0] = $items;

        return $list;
    }

    /**
     * @return array
     */
    public static function findRoleList(
        string $role = self::DEFAULT_ROLE,
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
