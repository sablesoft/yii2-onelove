<?php
namespace common\models;

use common\models\query\PartyMemberQuery;

/**
 * This is the model class for table "party_member".
 *
 * @property int $id
 * @property int $party_id
 * @property int $member_id
 * @property int $visited
 * @property int $paid
 *
 * @property Member $member
 * @property Party $party
 */
class PartyMember extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'party_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['party_id', 'member_id'], 'required'],
            [['party_id', 'member_id', 'visited', 'paid'], 'integer'],
            [['member_id', 'party_id'], 'unique', 'targetAttribute' => ['member_id', 'party_id']],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::class, 'targetAttribute' => ['member_id' => 'id']],
            [['party_id'], 'exist', 'skipOnError' => true, 'targetClass' => Party::class, 'targetAttribute' => ['party_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'party_id' => 'Party ID',
            'member_id' => 'Member ID',
            'visited' => 'Visited',
            'paid'      => 'Paid'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember() {
        return $this->hasOne( Member::class, ['id' => 'member_id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParty() {
        return $this->hasOne( Party::class, ['id' => 'party_id'] );
    }

    /**
     * {@inheritdoc}
     * @return PartyMemberQuery the active query used by this AR class.
     */
    public static function find() {
        return new PartyMemberQuery( get_called_class() );
    }
}
