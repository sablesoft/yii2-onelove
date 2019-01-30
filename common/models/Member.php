<?php
namespace common\models;

use yii\db\ActiveRecord;
use common\behavior\AgeBehavior;
use common\behavior\NameBehavior;
use common\behavior\PhoneBehavior;
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
 * @property int $minAge
 * @property int $maxAge
 * @property string $ageLabel
 * @property string $dob
 * @property int $sex
 * @property int $group_id Age search group ID
 * @property string $phone
 * @property string $email
 * @property string $resume
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property Ask[] $asks
 * @property Ticket[] $tickets
 * @property Party[] $parties
 * @property string $username
 * @property string $sexLabel
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 */
class Member extends BaseModel {

    const YEAR_IN_SECONDS = 31536000;

    /**
     * @return array
     */
    public function attributes() {
        return [
            'id', 'user_id', 'is_blocked',
            'name', 'phone', 'sex', 'age',
            'dob', 'photo', 'email', 'resume',
            'created_at', 'updated_at', 'group_id'
        ];
    }

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
            [['age', 'sex', 'group_id'], 'required'],
            [['user_id', 'age', 'sex', 'is_blocked', 'trueAge', 'group_id'], 'integer'],
            [['age'], 'integer', 'min' => $this->minAge, 'max' => $this->maxAge ],
            [['created_at', 'updated_at'], 'safe'],
            [['dob'], 'validateDob'],
            [['resume'], 'string'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 10],
            [['name'], 'validateName'],
            [['phone'], 'validatePhone'],
            [['photo'], 'string', 'max' => 40],
            [['email'], 'string', 'max' => 20],
            [['user_id'], 'unique'],
            [['phone'], 'unique'],
            [['email'], 'unique'],
            [
                ['group_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']
            ],
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
            'group_id' => \Yii::t('app', 'Group'),
            'groupLabel' => \Yii::t('app', 'Group'),
            'phone' => \Yii::t('app', 'Phone'),
            'maskedPhone' => \Yii::t('app', 'Phone'),
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
            AgeBehavior::class,
            NameBehavior::class,
            [
                'class'     => PhoneBehavior::class,
                'operators' => Helper::getSettings('operators')
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['dob'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['dob'],
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
     * @param string $attribute
     * @param $params
     */
    public function validateDob( string $attribute, $params ) {
        $ages = $this->trueAge;
        if( $ages < $this->minAge )
            $this->addError( $attribute, \Yii::t('app', 'Invalid day of birth') );
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
    public function getGroup() {
        return $this->hasOne( Group::class, ['id' => 'group_id']);
    }

    /**
     * @return string
     */
    public function getGroupLabel() :string {
        $group = $this->group;

        return $group ? $group->label : '';
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

        return (int) ( time() - strtotime( $this->dob ) ) / self::YEAR_IN_SECONDS;
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
