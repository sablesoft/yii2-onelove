<?php
namespace common\models;

use common\behavior\PhoneBehavior;
use common\models\query\PlaceQuery;

/**
 * This is the model class for table "place".
 *
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $map
 * @property string $photo
 * @property int $is_default
 * @property string $created_at
 * @property string $updated_at
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 *
 * @property Party[] $parties
 */
class Place extends BaseModel {

    protected $checkDefault = true;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'place';
    }

    public function behaviors() {
        return array_merge( parent::behaviors(), [
            PhoneBehavior::class
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // todo validate photo path
            [['name', 'address'], 'required'],
            [['is_default', 'is_blocked'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            // todo - validate phone operator code
            [['name', 'photo'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 100],
            [['map'], 'string'],
            [['phone'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['address'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Place Name'),
            'address' => \Yii::t('app', 'Address'),
            'phone' => \Yii::t('app', 'Phone'),
            'maskedPhone' => \Yii::t('app', 'Phone'),
            'map' => \Yii::t('app', 'Map'),
            'photo' => \Yii::t('app', 'Photo'),
            'is_default' => \Yii::t('app', 'Is Default'),
            'is_blocked' => \Yii::t('app', 'Is Blocked'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParties() {
        return $this->hasMany(Party::class, ['place_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->name;
    }

    /**
     * @return PlaceQuery
     */
    public static function findDefault() {
        return static::find()->where(['is_default' => 1])->one();
    }

    /**
     * {@inheritdoc}
     * @return PlaceQuery the active query used by this AR class.
     */
    public static function find() {
        return new PlaceQuery( get_called_class() );
    }
}
