<?php
namespace common\models;

use common\behavior\ImageBehavior;
use common\behavior\PhoneBehavior;
use common\models\query\PlaceQuery;
use noam148\imagemanager\models\ImageManager;

/**
 * This is the model class for table "place".
 *
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $map
 * @property string $photo
 * @property int $is_default
 * @property string|null $imagePath
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 *
 * @property Party[] $parties
 *
 * @method string|null getImagePath( $options = [] );
 */
class Place extends CrudModel {

    protected $checkDefault = true;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'place';
    }

    public function behaviors() {
        return array_merge( parent::behaviors(), [
            [
                'class'     => PhoneBehavior::class,
                'operators' => Helper::getSettings('operators')
            ],
            [
                'class' => ImageBehavior::class,
                'imageField' => 'photo'
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'address'], 'required'],
            [['is_default', 'is_blocked', 'photo'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 100],
            [['map'], 'string'],
            [['phone'], 'validatePhone'],
            [['name'], 'unique'],
            [['address'], 'unique'],
            [
                ['photo'], 'exist', 'skipOnError' => true,
                'targetClass' => ImageManager::class, 'targetAttribute' => ['photo' => 'id']
            ]
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
            'imagePath' => \Yii::t('app', 'Photo'),
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
     * @return Place|null
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
