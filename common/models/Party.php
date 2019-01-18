<?php
namespace common\models;

use common\models\query\PartyQuery;

/**
 * This is the model class for table "party".
 *
 * @property int $id
 * @property int $place_id
 * @property string $time
 * @property string $date
 * @property string $timestamp
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Place $place
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
            [['place_id', 'time', 'date', 'timestamp'], 'required'],
            [['place_id'], 'integer'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['time'], 'string', 'max' => 5],
            [['date'], 'string', 'max' => 8],
            [['place_id', 'timestamp'], 'unique', 'targetAttribute' => ['place_id', 'timestamp']],
            [['place_id'], 'exist', 'skipOnError' => true, 'targetClass' => Place::className(), 'targetAttribute' => ['place_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'place_id' => 'Place ID',
            'time' => 'Time',
            'date' => 'Date',
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
