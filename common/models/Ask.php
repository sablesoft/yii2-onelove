<?php

namespace common\models;

use Yii;

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
 * @property Party $party
 */
class Ask extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ask';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['party_id', 'member_id'], 'required'],
            [['party_id', 'member_id', 'processed', 'confirmed', 'visited', 'paid'], 'integer'],
            [['member_id', 'party_id'], 'unique', 'targetAttribute' => ['member_id', 'party_id']],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => Member::className(), 'targetAttribute' => ['member_id' => 'id']],
            [['party_id'], 'exist', 'skipOnError' => true, 'targetClass' => Party::className(), 'targetAttribute' => ['party_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'party_id' => Yii::t('app', 'Party ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'processed' => Yii::t('app', 'Processed'),
            'confirmed' => Yii::t('app', 'Confirmed'),
            'visited' => Yii::t('app', 'Visited'),
            'paid' => Yii::t('app', 'Paid'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id' => 'member_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParty()
    {
        return $this->hasOne(Party::className(), ['id' => 'party_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\AskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AskQuery(get_called_class());
    }
}
