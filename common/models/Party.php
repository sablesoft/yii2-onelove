<?php
namespace common\models;

use common\models\query\PartyQuery;

/**
 * This is the model class for table "party".
 *
 * @property int $id
 * @property int $place_id
 * @property string $timestamp
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Place $place
 * @property Price $price
 * @property PartyMember[] $partyMembers
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
            [['place_id', 'price_id', 'timestamp'], 'required'],
            [['place_id', 'price_id'], 'integer'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['place_id', 'timestamp'], 'unique', 'targetAttribute' => ['place_id', 'timestamp']],
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
            'id' => 'ID',
            'place_id' => 'Place ID',
            'price_id'  => 'Price ID',
            'timestamp' => 'Timestamp',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getPartyMembers() {
        return $this->hasMany( PartyMember::class, ['party_id' => 'id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers() {
        return $this->hasMany( Member::class, ['id' => 'member_id'] )
            ->viaTable('party_member', ['party_id' => 'id'] );
    }

    /**
     * {@inheritdoc}
     * @return PartyQuery the active query used by this AR class.
     */
    public static function find() {
        return new PartyQuery( get_called_class() );
    }
}
