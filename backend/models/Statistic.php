<?php

namespace backend\models;

use Yii;
use common\models\User;
use common\models\Helper;
use common\behavior\OperatorBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "statistic".
 *
 * @property int $id
 * @property string $date
 * @property int $view_desk
 * @property int $view_mobile
 * @property int $ask_make
 * @property int $ask_reject
 * @property int $ask_member
 * @property int $ask_accept
 * @property int $party_close
 * @property int $ticket_close
 * @property int $member_visit
 * @property int $member_pay
 * @property int $operator_id
 *
 * @property User $operator
 * @property string $operatorLabel
 * @property string $operatorUrl
 */
class Statistic extends \yii\db\ActiveRecord {

    const VIEW_DESK     = 'view_desk';
    const VIEW_MOBILE   = 'view_mobile';
    const ASK_MAKE      = 'ask_make';
    const ASK_REJECT    = 'ask_reject';
    const ASK_MEMBER    = 'ask_member';
    const ASK_ACCEPT    = 'ask_accept';
    const PARTY_CLOSE   = 'party_close';
    const TICKET_CLOSE  = 'ticket_close';
    const MEMBER_VISIT  = 'member_visit';
    const MEMBER_PAY    = 'member_pay';

    /** @var string $time - for diff time groups */
    public $time;
    public $isCheckDefault = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'statistic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date', 'operator_id'], 'required'],
            [
                [ self::VIEW_DESK, self::VIEW_MOBILE, self::ASK_MAKE, self::ASK_REJECT, self::ASK_MEMBER, self::ASK_ACCEPT,
                  self::PARTY_CLOSE, self::TICKET_CLOSE, self::MEMBER_VISIT, self::MEMBER_PAY, 'operator_id'],
                'integer'
            ],
            [
                [ self::VIEW_DESK, self::VIEW_MOBILE, self::ASK_MAKE, self::ASK_REJECT, self::ASK_MEMBER, self::ASK_ACCEPT,
                    self::PARTY_CLOSE, self::TICKET_CLOSE, self::MEMBER_VISIT, self::MEMBER_PAY],
                'default', 'value' => 0
            ],
            [['operator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['operator_id' => 'id']],
            [['date', 'operator_id'], 'unique', 'targetAttribute' => ['date', 'operator_id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app/backend', 'ID'),
            'date' => Yii::t('app/backend', 'Date'),
            self::VIEW_DESK => Yii::t('app/backend', 'Desktop Views'),
            self::VIEW_MOBILE => Yii::t('app/backend', 'Mobile Views'),
            self::ASK_MAKE => Yii::t('app/backend', 'Ask Make'),
            self::ASK_REJECT => Yii::t('app/backend', 'Ask Reject'),
            self::ASK_MEMBER => Yii::t('app/backend', 'Ask Member'),
            self::ASK_ACCEPT => Yii::t('app/backend', 'Ask Accept'),
            self::PARTY_CLOSE => Yii::t('app/backend', 'Party Close'),
            self::TICKET_CLOSE => Yii::t('app/backend', 'Ticket Close'),
            self::MEMBER_VISIT => Yii::t('app/backend', 'Member Visit'),
            self::MEMBER_PAY => Yii::t('app/backend', 'Member Pay'),
            'operator_id' => Yii::t('app/backend', 'Operator'),
            'operatorLabel' => Yii::t('app/backend', 'Operator')
        ];
    }

    public function behaviors() {
        return [
            'operator' =>  [
                'class'      => OperatorBehavior::class,
                'operatorField' => 'operator_id'
            ],
            'date' => [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE     => ['date'],
                    ActiveRecord::EVENT_BEFORE_INSERT       => ['date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE       => ['date']
                ],
                'value' => function( $event ) {
                    return $this->isNewRecord ?
                        date('Y-m-d') : $this->date;
                }
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperator() {
        return $this->hasOne(User::class, ['id' => 'operator_id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\StatisticQuery the active query used by this AR class.
     */
    public static function find() {
        return new \backend\models\query\StatisticQuery(get_called_class());
    }

    /**
     * @param string $field
     * @param integer $count
     * @return bool
     */
    public static function add( string $field, $count = 1 ) : bool {
        try {
            if( !$stat = Statistic::find()->active()->one() ) {
                $stat = new Statistic();
                $stat->save();
            }

            return $stat->updateCounters([ $field => $count ]);
        } catch ( \Exception $e ) {
            // todo
        }
            return false;
    }

    /**
     * @return bool
     */
    public static function addBrowsing() : bool {
        $statField = Helper::isMobile() ? self::VIEW_MOBILE : self::VIEW_DESK;
        return static::add( $statField );
    }
}
