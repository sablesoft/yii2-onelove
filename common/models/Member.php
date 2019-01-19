<?php
namespace common\models;

use common\models\query\MemberQuery;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property int $user_id
 * @property string $photo
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
 * @property Ask[] $asks
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
            // todo - validate photo path
            [['user_id', 'age', 'sex'], 'integer'],
            [['age', 'sex'], 'required'],
            [['dob', 'created_at', 'updated_at'], 'safe'],
            [['resume'], 'string'],
            [['name'], 'string', 'max' => 10],
            [['photo'], 'string', 'max' => 40],
            [['phone', 'email'], 'string', 'max' => 20],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [
                ['user_id'], 'exist', 'skipOnError' => true,
                'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'user_id' => \Yii::t('app', 'User ID'),
            'name' => \Yii::t('app', 'Name'),
            'age' => \Yii::t('app', 'Age'),
            'dob' => \Yii::t('app', 'Dob'),
            'sex' => \Yii::t('app', 'Sex'),
            'phone' => \Yii::t('app', 'Phone'),
            'photo' => \Yii::t('app', 'Photo'),
            'email' => \Yii::t('app', 'Email'),
            'resume' => \Yii::t('app', 'Resume'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
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
    public function getAsks() {
        return $this->hasMany( Ask::class, ['member_id' => 'id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParties() {
        return $this->hasMany( Party::class, ['id' => 'party_id'] )
            ->viaTable( Ask::tableName(), ['member_id' => 'id'] );
    }

    /**
     * {@inheritdoc}
     * @return MemberQuery the active query used by this AR class.
     */
    public static function find() {
        return new MemberQuery( get_called_class() );
    }
}
