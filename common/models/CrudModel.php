<?php
namespace common\models;

use yii\db\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\behavior\OwnerBehavior;
use yii\behaviors\AttributeBehavior;


/**
 * Class BaseModel
 *
 * @package common\models
 *
 * @property int $id
 * @property int $owner_id
 * @property int|string $created_at
 * @property int|string $updated_at
 * @property int $is_blocked
 * @property bool $isCheckDefault
 * @property string $label
 * @property User|null $ownerUser
 *
 * @method bool isOwner( int $userId );
 */
abstract class CrudModel extends ActiveRecord {

    /** @var integer */
    protected $checkDefault;

    /**
     * @return bool
     */
    public function getIsCheckDefault() : bool {
        return (bool) $this->checkDefault;
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
            [
                'class'     => OwnerBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['owner_id']
                ],
                'value' => function( $event ) {
                    return \Yii::$app->user->getIsGuest() ? null :
                            \Yii::$app->user->getId();
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['created_at']
                ],
                'value' => function( $event ) {
                    return $this->created_at ?
                        strtotime( $this->created_at ) : time();
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => function( $event ) {
                    return time();
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['created_at'],
                ],
                'value' => function( $event ) {
                    return date('Y-m-d H:i', $this->created_at );
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['updated_at'],
                ],
                'value' => function( $event ) {
                        return date('Y-m-d H:i', $this->updated_at );
                }
            ]
        ];
    }

    /**
     * @return array
     */
    public static function getDropDownList( $config = [] ) : array {
        // prepare items:
        $query = static::find();
        $where = !empty( $config['where'] )? $config['where'] : false;
        if( is_array( $where ) )
            $query = $query->where( $where );
        $models = $query->all();
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
     * @param bool $insert
     * @return bool
     */
    public function beforeSave( $insert ) {
        $result = $this->checkDefault ?
            $this->checkDefault() : true;

        return $result ?
            parent::beforeSave( $insert ) : false;
    }

    /**
     * @return bool
     */
    public function beforeDelete() : bool {
        if( $this->checkDefault && !empty( $this->is_default ) ) {
            \Yii::$app->getSession()->setFlash(
                'error',
                \Yii::t('app', 'Cannot delete default!' )
            );

            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * @return bool
     */
    protected function checkDefault() :bool {
        $default = self::find()->where(['is_default' => 1 ])->one();

        if( $default && $this->is_default ) {
            if( $default->id != $this->id ) {
                $id = $default->id;
                try {
                    \Yii::$app->db->createCommand("UPDATE price SET `is_default`=0 WHERE `id`=$id")
                        ->execute();
                } catch( Exception $e ) {
                    \Yii::error( $e->getMessage() );

                    return false;
                }
            }
        } else if( !$default )
            $this->is_default = true;

        return true;
    }

    abstract public function getId();
    abstract public function getLabel() : string;
}
