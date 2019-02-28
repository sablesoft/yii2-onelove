<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use common\behavior\AgeBehavior;
use common\behavior\NameBehavior;
use common\behavior\PhoneBehavior;
use common\behavior\ImageBehavior;
use common\models\query\MemberQuery;
use yii\behaviors\AttributeBehavior;
use common\models\query\TicketQuery;
use noam148\imagemanager\models\ImageManager;

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
 * @property string|null $imagePath
 *
 * @property User $user
 * @property Ask[] $asks
 * @property Ticket[] $tickets
 * @property Party[] $parties
 * @property array $columns
 * @property array $visits
 * @property integer $visitsCount
 * @property float $visitsPay
 * @property string $username
 * @property string $sexLabel
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 *
 * @method string|null getImagePath( $options = [] );
 */
class Member extends CrudModel {

    const YEAR_IN_SECONDS = 31536000;

    /**
     * @return array
     */
    public function attributes() {
        return [
            'id', 'user_id', 'is_blocked',
            'name', 'phone', 'sex', 'age',
            'dob', 'photo', 'email', 'resume', 'owner_id',
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
            [['age', 'sex', 'group_id'], 'required'],
            [['user_id', 'age', 'sex', 'is_blocked', 'trueAge', 'group_id', 'photo'], 'integer'],
            [['age'], 'integer', 'min' => $this->minAge, 'max' => $this->maxAge ],
            [['created_at', 'updated_at'], 'safe'],
            [['dob'], 'validateDob'],
            [['resume'], 'string'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 10],
            [['name'], 'validateName'],
            [['phone'], 'validatePhone'],
            [['email'], 'string', 'max' => 40],
            [['email'], 'filter', 'filter' => function( $value ) {
                if( !$value ) return null;
            }],
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
            ],
            [
                ['photo'], 'exist', 'skipOnError' => true,
                'targetClass' => ImageManager::class, 'targetAttribute' => ['photo' => 'id']
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
            'visitsCount' => \Yii::t('app', 'Visits Count'),
            'visitsPay' => \Yii::t('app', 'Visits Pay'),
            'sexLabel' => \Yii::t('app', 'Sex'),
            'group_id' => \Yii::t('app', 'Group'),
            'groupLabel' => \Yii::t('app', 'Age Group'),
            'phone' => \Yii::t('app', 'Phone'),
            'maskedPhone' => \Yii::t('app', 'Phone'),
            'photo' => \Yii::t('app', 'Photo'),
            'imagePath' => \Yii::t('app', 'Photo'),
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
        $behaviors = parent::behaviors();
        $behaviors['owner']['value'] = $this->owner_id;
        return array_merge( $behaviors, [
            AgeBehavior::class,
            NameBehavior::class,
            [
                'class' => ImageBehavior::class,
                'imageField' => 'photo'
            ],
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
     * @return array
     */
    public function getColumns() {
        $columns = [
            'imagePath:image',
            'name',
            'sexLabel',
            'groupLabel',
            'ageLabel',
            'dob:date',
            'maskedPhone',
            'email:email',
            'resume:ntext',
            'username',
            'visitsCount:integer'
        ];

        if( \Yii::$app->user->can('manager') )
            $columns = array_merge( $columns, [
                'visitsPay:decimal',
                'is_blocked:boolean',
            ]);

        return array_merge( $columns, [
            'created_at:datetime',
            'updated_at:datetime'
        ]);
    }

    /**
     * @param string $attribute
     * @param $params
     */
    public function validateDob( string $attribute, $params ) {
        $ages = $this->trueAge;
        if( $ages < $this->minAge )
            $this->addError( $attribute, \Yii::t('app/error', 'Invalid day of birth') );
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
     * @return \yii\db\ActiveQuery|TicketQuery
     */
    public function getTickets() {
        return $this->hasMany( Ticket::class, ['member_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getVisits() {
        return $this->getTickets()->visited()->select(['party_id', 'paid'])
            ->asArray()->all();
    }

    /**
     * @return int
     */
    public function getVisitsCount() {
        $visits = $this->visits;

        return count( $visits );
    }

    /**
     * @return float
     */
    public function getVisitsPay() {
        $visits = $this->visits;

        return (float) array_sum( ArrayHelper::getColumn( $visits, 'paid' ) );
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
        $label .= ' ( ' . $this->ageLabel . ' ):';
        $label .= ' ' . $this->maskedPhone;

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
