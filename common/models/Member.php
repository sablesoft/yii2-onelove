<?php
namespace common\models;

use common\models\query\MemberQuery;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $age
 * @property string $dob
 * @property int $sex
 * @property string $phone
 * @property string $email
 * @property string $resume
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property PartyMember[] $partyMembers
 * @property Party[] $parties
 */
class Member extends \yii\db\ActiveRecord {
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'age', 'sex'], 'integer'],
            [['age', 'sex'], 'required'],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['resume'], 'string'],
            [['name'], 'string', 'max' => 10],
            [['phone', 'email'], 'string', 'max' => 20],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'age' => 'Age',
            'dob' => 'Dob',
            'sex' => 'Sex',
            'phone' => 'Phone',
            'email' => 'Email',
            'resume' => 'Resume',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartyMembers() {
        return $this->hasMany( PartyMember::class, ['member_id' => 'id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParties() {
        return $this->hasMany( Party::class, ['id' => 'party_id'] )
            ->viaTable('party_member', ['member_id' => 'id'] );
    }

    /**
     * {@inheritdoc}
     * @return MemberQuery the active query used by this AR class.
     */
    public static function find() {
        return new MemberQuery( get_called_class() );
    }
}
