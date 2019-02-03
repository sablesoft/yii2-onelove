<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "ticket".
 *
 * @property int $party_id Ticket party ID
 * @property int $member_id Ticket member ID
 * @property string $comment Operator comments
 * @property int $visited Is party visited by member flag
 * @property int $paid How much member paid for party
 * @property int $closed Is ticket closed
 * @property int $updated_by Who make last ticket updates
 *
 * @property Member $member
 * @property Party $party
 * @property string $memberLabel
 * @property string $memberSex
 * @property string $memberSexLabel
 * @property string $memberAgeLabel
 * @property array $memberUrl
 * @property string $partyLabel
 * @property array $partyUrl
 * @property string $operatorLabel
 * @property string $operatorUrl
 * @property User $updatedBy
 */
class Ticket extends CrudModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ticket';
    }

    /**
     * @return array
     */
    public function attributes() {
        return [
            'id', 'member_id', 'party_id', 'updated_by',
            'visited', 'paid', 'is_blocked', 'closed',
            'comment', 'created_at', 'updated_at', 'owner_id'
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return array_merge( parent::behaviors(), [
            'updatedBy' =>  [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => ['updated_by'],
                    ActiveRecord::EVENT_BEFORE_INSERT   => ['updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE   => ['updated_by']
                ],
                'value' => function( $event ) {
                    return Yii::$app->user->getId();
                }
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['party_id', 'member_id', 'updated_by'], 'required'],
            [
                ['party_id', 'member_id', 'visited',
                    'paid', 'is_blocked', 'closed',
                    'updated_by', 'created_at', 'updated_at'],
                'integer'
            ],
            [['comment'], 'string'],
            [['member_id', 'party_id'], 'unique', 'targetAttribute' => ['member_id', 'party_id']],
            [
                ['member_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Member::class, 'targetAttribute' => ['member_id' => 'id']
            ],
            [
                ['party_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Party::class, 'targetAttribute' => ['party_id' => 'id']
            ],
            [
                ['updated_by'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']
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
            'member_id' => Yii::t('app', 'Member'),
            'comment' => Yii::t('app', 'Operator Comment'),
            'visited' => Yii::t('app', 'Visited'),
            'paid' => Yii::t('app', 'Paid'),
            'partyLabel' => Yii::t('app', 'Party'),
            'memberLabel' => Yii::t('app', 'Member'),
            'memberSex' => Yii::t('app', 'Sex'),
            'memberSexLabel' => Yii::t('app', 'Sex'),
            'memberAge' => Yii::t('app', 'Age'),
            'memberAgeLabel' => Yii::t('app', 'Age'),
            'operatorLabel' => Yii::t('app', 'Operator'),
            'is_blocked' => Yii::t('app', 'Is Blocked'),
            'closed' => Yii::t('app', 'Closed'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At')
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
     * @return string
     */
    public function getMemberLabel() : string {
        $member = $this->member;

        return $member ? $member->label : '';
    }

    /**
     * @return int|null
     */
    public function getMemberSex() {
        $member = $this->member;

        return $member ? $member->sex : null;
    }

    /**
     * @return string
     */
    public function getMemberSexLabel() : string {
        $member = $this->member;

        return $member ? $member->sexLabel : '';
    }

    /**
     * @return string
     */
    public function getMemberAgeLabel() : string {
        $member = $this->member;

        return $member ? $member->ageLabel : '';
    }

    /**
     * @return int|null
     */
    public function getMemberAge() {
        $member = $this->member;

        return $member ? $member->age : null;
    }

    /**
     * @return array
     */
    public function getMemberUrl() : array {
        return ['/member/view', 'id' => $this->member_id ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy() {
        return $this->hasOne( User::class, ['id' => 'updated_by'] );
    }

    /**
     * @return string
     */
    public function getOperatorLabel() :string {
        if( !$operator = $this->updatedBy ) return '';

        return $operator->username;
    }

    /**
     * @return array
     */
    public function getOperatorUrl() : array {
        return [ '/user/profile/show', 'id' => $this->updated_by ];
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
        return $this->partyLabel . ' - ' . $this->memberLabel;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\TicketQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\TicketQuery( get_called_class() );
    }
}
