<?php

namespace common\models;

use Yii;
use common\models\query\AskQuery;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ask".
 *
 * @property int $id
 * @property int $party_id
 * @property int $member_id
 * @property int $updated_by
 * @property string $comment
 * @property int $processed
 * @property int $confirmed
 * @property int $visited
 * @property int $paid
 * @property int $closed
 *
 * @property Member $member
 * @property string $memberLabel
 * @property array $memberUrl
 * @property Party $party
 * @property User|null $lastOperator
 * @property string $partyLabel
 * @property string $operatorLabel
 * @property array $partyUrl
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
            [['party_id', 'member_id'], 'required'],
            [   [
                'party_id', 'member_id', 'updated_by', 'processed',
                'confirmed', 'visited', 'paid',
                'is_blocked', 'closed'
                ], 'integer'
            ],
            [['member_id', 'party_id'], 'unique', 'targetAttribute' => ['member_id', 'party_id']],
            [['comment'], 'string'],
            [
                ['member_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Member::class, 'targetAttribute' => ['member_id' => 'id']
            ],
            [
                ['updated_by'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['updated_by' => 'id']
            ],
            [
                ['party_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Party::class, 'targetAttribute' => ['party_id' => 'id']
            ]
        ];
    }

    public function behaviors() {
        return array_merge( parent::behaviors(), [
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by']
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
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'party_id' => Yii::t('app', 'Party'),
            'partyLabel' => Yii::t('app', 'Party'),
            'member_id' => Yii::t('app', 'Member'),
            'comment' => Yii::t('app', 'Comment'),
            'memberLabel' => Yii::t('app', 'Member'),
            'operatorLabel' => Yii::t('app', 'Operator'),
            'processed' => Yii::t('app', 'Processed'),
            'confirmed' => Yii::t('app', 'Confirmed'),
            'visited' => Yii::t('app', 'Visited'),
            'is_blocked' => Yii::t('app', 'Is Blocked'),
            'closed' => Yii::t('app', 'Closed'),
            'paid' => Yii::t('app', 'Paid'),
            'updated_by' => Yii::t('app', 'Operator')
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
     * @return \yii\db\ActiveQuery
     */
    public function getLastOperator() {
        return $this->hasOne( User::class, ['id' => 'updated_by'] );
    }

    /**
     * @return string
     */
    public function getOperatorLabel() :string {
        if( !$operator = $this->lastOperator ) return '';

        return $operator->username;
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
     * @return AskQuery the active query used by this AR class.
     */
    public static function find() {
        return new AskQuery( get_called_class() );
    }
}
