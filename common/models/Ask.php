<?php

namespace common\models;

use Yii;
use backend\models\Statistic;
use common\behavior\AgeBehavior;
use common\behavior\NameBehavior;
use common\behavior\PhoneBehavior;
use common\models\query\AskQuery;
use yii\db\StaleObjectException;

/**
 * This is the model class for table "ask".
 *
 * @property string $name
 * @property string $phone
 * @property int $age
 * @property int $sex
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
class Ask extends CrudModel {

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
            'name', 'phone', 'sex', 'age', 'owner_id',
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
            'groupLabel' => Yii::t('app', 'Age Group'),
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

        return $group ? Yii::t('app', $group->label ) : '';
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
     * @return bool
     */
    public function make() : bool {
        $success = $this->save();

        if( $success )
            Statistic::add('ask_make');

        return $success;
    }

    /**
     * @return Member
     * @throws \Exception
     */
    public function member() : Member {
        $member = Member::findOne([ 'phone' => $this->phone ]) ?: new Member();
        $isNew = $member->isNewRecord;
        $member->setAttributes( $this->getAttributes(['name', 'phone', 'age', 'sex', 'group_id']) );
        // create or update member:
        $member->save();
        // check member save correct:
        if( !$member->id )
            throw new \Exception(Yii::t('app/error', 'Member not saved!'));

        if( $isNew )
            Statistic::add( 'ask_member' );

        try {
            $this->delete();
        } catch (StaleObjectException $e) {
        } catch (\Throwable $e) {
            Yii::error( $e->getMessage() );
            Yii::$app->session->addFlash('error', $e->getMessage() );
        }

        return $member;
    }

    /**
     * @return bool
     */
    public function accept( $partyId = null ) : bool {
        // search and check party:
        if( !$party = ( $partyId ? Party::findActiveOne(['id' => $partyId ]) : Party::findCurrent() ) ) {
            $error = Yii::t('app/error', 'Active party for ticket not found!');
            Yii::error( $error );
            Yii::$app->session->addFlash('error', $error );

            return false;
        }
        try {
            // create or update member and delete ask:
            $member = $this->member();
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

                throw new \Exception(Yii::t('app/error', 'Ticket not saved!'));
            }
        } catch ( \Throwable $e ) {
            Yii::error( $e->getMessage() );
            Yii::$app->session->addFlash('error', $e->getMessage() );

            return false;
        }

        Statistic::add( 'ask_accept' );

        return true;
    }

    /**
     * @return bool
     */
    public function reject() : bool {
        try {
            if ($this->delete() === false)
                return false;

            Statistic::add('ask_reject');

            return true;
        } catch (StaleObjectException $e) {
        } catch (\Throwable $e) {
        }
        return false;

    }

    /**
     * @return bool
     */
    public static function acceptAll( $partyId = null ) : bool {
        $count = 0;
        $success = true;
        $asks = Ask::find()->all();
        /** @var Ask $ask */
        foreach( (array) $asks as $ask )
            if( !$ask->accept( $partyId ) ) {
                $success = false;
            } else $count++;

        Statistic::add('ask_accept', $count );

        return $success;
    }

    /**
     * @return bool
     */
    public static function rejectAll() : bool {
        $count = static::find()->count();
        $result = static::deleteAll();
        if( $result )
            Statistic::add('ask_reject', $count );

        return $result;
    }

    /**
     * @return bool
     */
    public static function noEmpty() : bool {
        return !!static::find()->one();
    }

    /**
     * {@inheritdoc}
     * @return AskQuery the active query used by this AR class.
     */
    public static function find() {
        return new AskQuery( get_called_class() );
    }
}
