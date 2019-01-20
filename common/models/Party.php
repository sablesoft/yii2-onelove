<?php
namespace common\models;

use common\models\query\PartyQuery;

/**
 * This is the model class for table "party".
 *
 * @property int $id
 * @property string $name
 * @property int $place_id
 * @property int $price_id
 * @property string $timestamp
 * @property integer $max_members
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Ask[] $asks
 * @property Place $place
 * @property Price $price
 * @property Member[] $members
 */
class Party extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'party';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['place_id', 'price_id', 'timestamp', 'max_members'], 'required'],
            [['place_id', 'price_id', 'max_members'], 'integer'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['description'], 'string'],
            [
                ['place_id', 'timestamp'], 'unique',
                'targetAttribute' => ['place_id', 'timestamp']
            ],
            [
                ['place_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Place::class, 'targetAttribute' => ['place_id' => 'id']
            ],
            [
                ['price_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Price::class, 'targetAttribute' => ['price_id' => 'id']
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'place_id' => \Yii::t('app', 'Place ID'),
            'price_id'  => \Yii::t('app', 'Price ID'),
            'timestamp' => \Yii::t('app', 'Timestamp'),
            'max_members'    => \Yii::t('app', 'Max Members'),
            'description' => \Yii::t('app', 'Description'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace() {
        return $this->hasOne(Place::class, ['id' => 'place_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice() {
        return $this->hasOne(Price::class, ['id' => 'price_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsks() {
        return $this->hasMany( Ask::class, ['party_id' => 'id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers() {
        return $this->hasMany( Member::class, ['id' => 'member_id'] )
            ->viaTable( Ask::tableName(), ['party_id' => 'id'] );
    }

    /**
     * {@inheritdoc}
     * @return PartyQuery the active query used by this AR class.
     */
    public static function find() {
        return new PartyQuery( get_called_class() );
    }
}
