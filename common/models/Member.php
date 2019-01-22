<?php
namespace common\models;

use yii\db\ActiveRecord;
use common\models\query\MemberQuery;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "member".
 *
 * @property int $id
 * @property int $user_id
 * @property string $photo
 * @property string $name
 * @property int $age
 * @property int $trueAge
 * @property string $ageLabel
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
 * @property string $username
 * @property string $sexLabel
 */
class Member extends BaseModel {

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
            [['user_id', 'age', 'sex', 'is_blocked', 'trueAge'], 'integer'],
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
            'user_id' => \Yii::t('app', 'User'),
            'username' => \Yii::t('app', 'User'),
            'name' => \Yii::t('app', 'Name'),
            'age' => \Yii::t('app', 'Age'),
            'ageLabel' => \Yii::t('app', 'Age'),
            'trueAge' => \Yii::t('app', 'Age'),
            'dob' => \Yii::t('app', 'Day of Birth'),
            'sex' => \Yii::t('app', 'Sex'),
            'sexLabel' => \Yii::t('app', 'Sex'),
            'phone' => \Yii::t('app', 'Phone'),
            'photo' => \Yii::t('app', 'Photo'),
            'email' => \Yii::t('yii', 'Email'),
            'resume' => \Yii::t('app', 'Member Resume'),
            'is_blocked' => \Yii::t('app', 'Is Blocked'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return array_merge( parent::behaviors(), [
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dob'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dob']
                ],
                'value' => function( $event ) {
                    return $this->dob ?
                        strtotime( $this->dob ) : null;
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['dob'],
                ],
                'value' => function( $event ) {
                    return $this->dob ?
                        date('Y-m-d H:i', $this->dob ) : null;
                }
            ]
        ]);
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
     * @return string
     */
    public function getAgeLabel() : string {
        if( !$word = $this->_ageLabel() )
            return '';
        $message = "{0} $word";

        return \Yii::t('app', $message, $this->age );
    }

    /**
     * @return string
     */
    protected function _ageLabel() : string {
        $age = $this->age;
        if( !$age )
            return '';

        $num = $age > 100 ? substr( $age, -2 ) : $age;
        if( $num >= 5 && $num <= 14 ) {
            return 'ages';
        } else {
            $num = substr( $age, -1 );
            if( $num == 0 || ( $num >= 5 && $num <= 9 ) ) return 'ages';
            if( $num == 1 ) return 'year';
            if( $num >= 2 && $num <= 4 ) return 'years';
        }
        return '';
    }

    /**
     * @return string
     */
    public function getSexLabel() : string {
        return array_key_exists( (int) $this->sex, static::getSexDropDownList() )?
            static::getSexDropDownList()[ (int) $this->sex ] : '';
    }

    /**
     * @return int
     */
    public function getTrueAge() {
        if( !$this->dob )
            return $this->age;
        // todo
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setTrueAge( $age ) {
        $this->age = (int) $age;
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
    public function getUsername() : string {
        if( !$user = $this->user )
            return '';

        return (string) $user->username;
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        $label = $this->name;
        if( $username = $this->username )
            $label .= " [ $username ]";
        $label .= ' ( ' . $this->ageLabel . ' )';

        return $label;
    }

    /**
     * {@inheritdoc}
     * @return MemberQuery the active query used by this AR class.
     */
    public static function find() {
        return new MemberQuery( get_called_class() );
    }

    /**
     * @return array
     */
    public static function getSexDropDownList() : array {
        return [
            \Yii::t('app', 'Female' ),
            \Yii::t('app', 'Male' )
        ];
    }
}
