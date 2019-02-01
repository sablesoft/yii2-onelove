<?php

namespace common\models;

use Yii;
use common\behavior\AgeBehavior;
use common\behavior\NameBehavior;
use common\behavior\PhoneBehavior;
use common\models\query\AskQuery;

/**
 * This is the model class for table "ask".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $label
 * @property int $age
 * @property int $sex
 * @property int $created_at
 * @property int $group_id Age search group ID
 *
 * @property int $minAge
 * @property int $maxAge
 * @property Group $group
 * @property string $groupLabel
 * @property string $ageLabel
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 */
class Ask extends BaseModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ask';
    }

    /**
     * @return array
     */
    public function attributes() {
        return [
            'name', 'phone', 'sex', 'age',
            'created_at', 'updated_at', 'group_id'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'phone', 'age', 'sex', 'group_id'], 'required'],
            [['sex'], 'integer', 'min' => 0, 'max' => 1],
            [['name'], 'trim'],
            [['group_id'], 'integer'],
            [['name'], 'string', 'max' => 20 ],
            [['name'], 'validateName'],
            [['phone'], 'validatePhone'],
            [['age'], 'integer', 'min' => $this->minAge, 'max' => $this->maxAge ],
            [['created_at', 'updated_at'], 'safe'],
            [['phone'], 'unique'],
            [
                ['group_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Group::class, 'targetAttribute' => ['group_id' => 'id']
            ]
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
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'age' => Yii::t('app', 'Age'),
            'ageLabel' => Yii::t('app', 'Age'),
            'maskedPhone' => \Yii::t('app', 'Phone'),
            'sex' => Yii::t('app', 'Sex'),
            'sexLabel' => \Yii::t('app', 'Sex'),
            'group_id' => Yii::t('app', 'Group'),
            'groupLabel' => Yii::t('app', 'Group'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return string
     */
    public function getSexLabel() : string {
        return array_key_exists( (int) $this->sex, Member::getSexDropDownList() )?
            Member::getSexDropDownList()[ (int) $this->sex ] : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup() {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return string
     */
    public function getGroupLabel() :string {
        $group = $this->group;

        return $group ? $group->label : '';
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->phone;
    }

    public static function primaryKey() {
        return ['phone'];
    }

    /**
     * @return string
     */
    public function getLabel() : string {
        return $this->name . ': ' . $this->maskedPhone;
    }

    /**
     * @return Member
     * @throws \Exception
     */
    public function memberSave() : Member {
        $member = Member::findOne([ 'phone' => $this->phone ]) ?: new Member();
        $member->setAttributes( $this->getAttributes(['name', 'phone', 'age', 'sex', 'group_id']) );
        // create or update member:
        $member->save();
        // check member save correct:
        if (!$member->id)
            throw new \Exception(Yii::t('app', 'Member not saved!'));

        return $member;
    }

    /**
     * @return bool
     */
    public function accept( $partyId = null ) : bool {
        // search and check party:
        if( !$party = ( $partyId ? Party::findActiveOne(['id' => $partyId ]) : Party::findCurrent() ) ) {
            $error = Yii::t('app', 'Active party for ticket not found!');
            Yii::error( $error );
            Yii::$app->session->addFlash('error', $error );

            return false;
        }
        try {
            // create or update member:
            $member = $this->memberSave();
            // prepare ticket data:
            $data = [
                'member_id' => $member->id,
                'party_id' => $party->id,
                'closed' => 0
            ];
            // check ticket exist:
            if( $oldTicket = Ticket::findOne( $data ) )
                throw new \Exception(
                    Yii::t(
                        'app',
                        'Ticket for this party and for this member already exist!'
                    )
                );
            $ticket = new Ticket( $data );
            $ticket->save();
            // check member save correct:
            if( !$ticket->id ) {
                foreach( $ticket->getErrors() as $error )
                    Yii::$app->session->addFlash('error', reset( $error ) );

                throw new \Exception(Yii::t('app', 'Ticket not saved!'));
            }

            $this->delete();
        } catch ( \Throwable $e ) {
            Yii::error( $e->getMessage() );
            Yii::$app->session->addFlash('error', $e->getMessage() );

            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public static function noEmpty() : bool {
        return !!static::find()->one();
    }

    /**
     * @return bool
     */
    public static function acceptAll( $partyId = null ) : bool {
        $success = true;
        $asks = Ask::find()->all();
        /** @var Ask $ask */
        foreach( (array) $asks as $ask )
            if( !$ask->accept( $partyId ) )
                $success = false;

        return $success;
    }

    /**
     * {@inheritdoc}
     * @return AskQuery the active query used by this AR class.
     */
    public static function find() {
        return new AskQuery( get_called_class() );
    }
}
