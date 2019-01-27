<?php

namespace common\models;

use Yii;
use common\behavior\AgeBehavior;
use common\behavior\NameBehavior;
use common\behavior\PhoneBehavior;
use common\models\query\AskQuery;

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
 * @property int $minAge
 * @property int $maxAge
 * @property string $ageLabel
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 */
class Ask extends BaseModel {

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
            [['name', 'phone', 'age', 'sex'], 'required'],
            [['sex'], 'integer', 'min' => 0, 'max' => 1],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 20 ],
            [['name'], 'validateName'],
            [['phone'], 'validatePhone'],
            [['age'], 'integer', 'min' => $this->minAge, 'max' => $this->maxAge ],
            [['created_at', 'updated_at'], 'safe'],
            [['phone'], 'unique']
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return array_merge( parent::behaviors(), [
            AgeBehavior::class,
            NameBehavior::class,
            PhoneBehavior::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'age' => Yii::t('app', 'Age'),
            'ageLabel' => Yii::t('app', 'Age'),
            'maskedPhone' => \Yii::t('app', 'Phone'),
            'sex' => Yii::t('app', 'Sex'),
            'sexLabel' => \Yii::t('app', 'Sex'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return string
     */
    public function getSexLabel() : string {
        return array_key_exists( (int) $this->sex, Member::getSexDropDownList() )?
            Member::getSexDropDownList()[ (int) $this->sex ] : '';
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->phone;
    }

    public static function primaryKey() {
        return ['phone'];
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->name . ': ' . $this->maskedPhone;
    }

    /**
     * {@inheritdoc}
     * @return AskQuery the active query used by this AR class.
     */
    public static function find() {
        return new AskQuery( get_called_class() );
    }
}
