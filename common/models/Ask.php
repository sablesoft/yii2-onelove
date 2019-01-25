<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\query\AskQuery;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "ask".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $label
 * @property int $age
 * @property int $sex
 * @property int $created_at
 *
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 */
class Ask extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ask';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'phone'], 'required'],
            [['age', 'sex'], 'integer'],
            [['name', 'phone'], 'string'],
            [['phone'], 'unique']
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return [
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
                    ActiveRecord::EVENT_AFTER_FIND => ['created_at'],
                ],
                'value' => function( $event ) {
                    return date('Y-m-d H:i', $this->created_at );
                }
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'age' => Yii::t('app', 'Age'),
            'sex' => Yii::t('app', 'Sex'),
            'created_at' => Yii::t('app', 'Created At')
        ];
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->name . ' - ' . $this->phone;
    }

    /**
     * {@inheritdoc}
     * @return AskQuery the active query used by this AR class.
     */
    public static function find() {
        return new AskQuery( get_called_class() );
    }
}
