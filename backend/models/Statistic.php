<?php

namespace backend\models;

use Yii;
use common\models\User;
use common\behavior\OperatorBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "statistic".
 *
 * @property int $id
 * @property string $date
 * @property int $ask_make
 * @property int $ask_reject
 * @property int $ask_member
 * @property int $ask_accept
 * @property int $operator_id
 *
 * @property User $operator
 * @property string $operatorLabel
 * @property string $operatorUrl
 */
class Statistic extends \yii\db\ActiveRecord {

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
            [['date'], 'safe'],
            [['ask_make', 'ask_reject', 'ask_member', 'ask_accept', 'operator_id'], 'integer'],
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
            'ask_make' => Yii::t('app/backend', 'Ask Make'),
            'ask_reject' => Yii::t('app/backend', 'Ask Reject'),
            'ask_member' => Yii::t('app/backend', 'Ask Member'),
            'ask_accept' => Yii::t('app/backend', 'Ask Accept'),
            'operator_id' => Yii::t('app/backend', 'Operator')
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
}
