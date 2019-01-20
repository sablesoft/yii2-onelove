<?php

namespace common\models;

use Yii;
use common\models\query\AskQuery;

/**
 * This is the model class for table "ask".
 *
 * @property int $id
 * @property int $party_id
 * @property int $member_id
 * @property int $processed
 * @property int $confirmed
 * @property int $visited
 * @property int $paid
 *
 * @property Member $member
 * @property string $memberLabel
 * @property array $memberUrl
 * @property Party $party
 * @property string $partyLabel
 * @property array $partyUrl
 */
class Ask extends \yii\db\ActiveRecord {

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
            [['party_id', 'member_id'], 'required'],
            [['party_id', 'member_id', 'processed', 'confirmed', 'visited', 'paid'], 'integer'],
            [['member_id', 'party_id'], 'unique', 'targetAttribute' => ['member_id', 'party_id']],
            [
                ['member_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Member::class, 'targetAttribute' => ['member_id' => 'id']
            ],
            [
                ['party_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Party::class, 'targetAttribute' => ['party_id' => 'id']
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'party_id' => Yii::t('app', 'Party'),
            'partyLabel' => Yii::t('app', 'Party'),
            'member_id' => Yii::t('app', 'Member'),
            'memberLabel' => Yii::t('app', 'Member'),
            'processed' => Yii::t('app', 'Processed'),
            'confirmed' => Yii::t('app', 'Confirmed'),
            'visited' => Yii::t('app', 'Visited'),
            'paid' => Yii::t('app', 'Paid')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember() {
        return $this->hasOne( Member::class, ['id' => 'member_id'] );
    }

    /**
     * @return string
     */
    public function getMemberLabel() : string {
        $member = $this->member;

        return $member ? $member->label : '';
    }

    /**
     * @return array
     */
    public function getMemberUrl() : array {
        return ['/member/view', 'id' => $this->member_id ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParty() {
        return $this->hasOne( Party::class, ['id' => 'party_id'] );
    }

    /**
     * @return string
     */
    public function getPartyLabel() : string {
        $party = $this->party;

        return $party ? $party->label : '';
    }

    /**
     * @return array
     */
    public function getPartyUrl() : array {
        return ['/party/view', 'id' => $this->party_id ];
    }

    /**
     * {@inheritdoc}
     * @return AskQuery the active query used by this AR class.
     */
    public static function find() {
        return new AskQuery( get_called_class() );
    }
}
