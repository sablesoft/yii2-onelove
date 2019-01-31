<?php
namespace common\models;

use common\behavior\PhoneBehavior;
use common\models\query\PartyQuery;
use common\models\query\PriceQuery;
use common\models\query\UserQuery;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "party".
 *
 * @property string $name
 * @property int $place_id
 * @property int $price_id
 * @property string $operator_ids
 * @property string $timestamp
 * @property integer $max_members
 * @property integer $closed
 * @property string $description
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Ask[] $asks
 * @property Place $place
 * @property Place|null $currentPlace
 * @property string $placeLabel
 * @property array $placeUrl
 * @property int $membersDelta
 * @property int $membersCount
 * @property Price $price
 * @property Price $currentPrice
 * @property string $priceLabel
 * @property string $timeLabel
 * @property string $membersLabel
 * @property string $operatorsLabel
 * @property string $map
 * @property array $priceUrl
 * @property Member[] $members
 * @property User[] $operators
 * @property string $countryCode
 * @property string $shortPhone
 * @property string $maskedPhone
 * @property string $currentPhone
 * @property string $phoneLabel
 * @property string $phoneLink
 * @property array $maskedPhoneConfig
 *
 * @method string getMaskedPhone( $phone = null );
 * @method string getMessengerHref( string $messenger );
 */
class Party extends BaseModel {

    const MEMBERS_DELTA = 5;
    const MEMBERS_COUNT = 15;

    const WIDGET_DATETIME = 'd F H:i';

    public function behaviors() {
        return array_merge( parent::behaviors(), [
            [
                'class'         => PhoneBehavior::class,
                'operators'     => Helper::getSettings('operators'),
                'messengers'    => Helper::getSettings('messengersConfig')
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['timestamp']
                ],
                'value' => function( $event ) {
                    return $this->timestamp ?
                        strtotime( $this->timestamp ) : time();
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['timestamp'],
                ],
                'value' => function( $event ) {
                    return date('Y-m-d H:i', $this->timestamp );
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['operator_ids'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['operator_ids']
                ],
                'value' => function( $event ) {
                    return !empty( $this->operator_ids ) && is_array( $this->operator_ids ) ?
                        implode( ",", $this->operator_ids ) : '';
                }
            ],
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['operator_ids'],
                ],
                'value' => function( $event ) {
                    return !empty( $this->operator_ids ) && is_string( $this->operator_ids ) ?
                        explode( ",", $this->operator_ids ) : [];
                }
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'party';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['place_id', 'price_id', 'timestamp', 'max_members'], 'required'],
            [['place_id', 'price_id', 'max_members', 'is_blocked', 'closed'], 'integer'],
            [['timestamp', 'operator_ids', 'created_at', 'updated_at'], 'safe'],
            [['name', 'phone'], 'string', 'max' => 30],
            [['description'], 'string'],
            [
                ['place_id', 'timestamp'], 'unique',
                'targetAttribute' => ['place_id', 'timestamp']
            ],
            [
                ['place_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Place::class, 'targetAttribute' => ['place_id' => 'id']
            ],
            [
                ['price_id'], 'exist', 'skipOnError' => true,
                'targetClass' => Price::class, 'targetAttribute' => ['price_id' => 'id']
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Party Name'),
            'place_id' => \Yii::t('app', 'Place'),
            'placeLabel' => \Yii::t('app', 'Place'),
            'price_id'  => \Yii::t('app', 'Price'),
            'operator_ids'  => \Yii::t('app', 'Operators'),
            'priceLabel'  => \Yii::t('app', 'Price'),
            'timestamp' => \Yii::t('app', 'Timestamp'),
            'max_members'    => \Yii::t('app', 'Max Members'),
            'description' => \Yii::t('app', 'Description'),
            'phone'     => \Yii::t('app', 'Operator Phone'),
            'maskedPhone'  => \Yii::t('app', 'Operator Phone'),
            'phoneLabel'  => \Yii::t('app', 'Operator Phone'),
            'is_blocked' => \Yii::t('app', 'Is Blocked'),
            'closed' => \Yii::t('app', 'Closed'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlace() {
        return $this->hasOne(Place::class, ['id' => 'place_id']);
    }

    /**
     * @return Place
     */
    public function getCurrentPlace() {
        return $this->place ?: Place::findDefault();
    }

    /**
     * @return string
     */
    public function getCurrentPhone() :string {
        $phone = $this->phone ?: Helper::getSettings('defaultPhone');

        return $this->getMaskedPhone( $phone );
    }

    /**
     * @return string
     */
    public function getPlaceLabel() : string {
        if( !$place = $this->place )
            $place = Place::findDefault();

        if( !$place )
            return '';

        return $place->label;
    }

    /**
     * @return array
     */
    public function getPlaceUrl() : array {
        return ['/place/view', 'id' => $this->place_id ];
    }

    /**
     * @return string
     */
    public function getMap() : string {
        if( !$place = $this->place )
            $place = Place::findDefault();

        if( !$place )
            return '';

        return $place->map;
    }

    /**
     * @return PriceQuery|ActiveQuery
     */
    public function getPrice() {
        return $this->hasOne(Price::class, ['id' => 'price_id']);
    }

    /**
     * @return Price|null
     */
    public function getCurrentPrice() {
        return $this->price ?: Price::findDefault();
    }

    /**
     * @return string
     */
    public function getPriceLabel() : string {
        if( !$price = $this->price )
            $price = Price::findDefault();

        if( !$price )
            return '';

        return $price->label;
    }

    /**
     * @return array
     */
    public function getPriceUrl() : array {
        return ['/price/view', 'id' => $this->price_id ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsks() {
        return $this->hasMany( Ask::class, ['party_id' => 'id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers() {
        return $this->hasMany( Member::class, ['id' => 'member_id'] )
            ->viaTable( Ask::tableName(), ['party_id' => 'id'] );
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getLabel(): string {
        if( $this->name )
            return $this->name;

        return $this->placeLabel . ' - ' . \Yii::$app->formatter->asDatetime( $this->timestamp );
    }

    /**
     * @param string $format
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function getTimeLabel() : string {
        if( !$this->timestamp )
            return '';

        $label = \Yii::$app->formatter->asDatetime(
            $this->timestamp, 'php:d mm H:i'
        );

        if( $label[0] == '0' )
            $label = substr( $label, 1);

        return $label;
    }

    /**
     * @return string
     */
    public function getMembersLabel() : string {
        $delta = $this->membersDelta;
        $middle = $this->membersCount;
        $min = $middle - $delta;
        $max = $middle + $delta;
        $count = $min . ' - ' . $max;

        return \Yii::t('app', '{0} guests', $count);
    }

    public function getMembersDelta() {
        return (int) Helper::getSettings('members.delta' ) ?:
            self::MEMBERS_DELTA;
    }

    public function getMembersCount() {
        return (int) $this->max_members ?: ( Helper::getSettings('members.count' ) ?:
            self::MEMBERS_COUNT );
    }

    /**
     * @return UserQuery
     */
    public function getOperators() : UserQuery {
        $query = User::find()->where(['id' => $this->operator_ids ]);
        $query->multiple = true;

        return $query;
    }

    /**
     * @return string
     */
    public function getOperatorsLabel() : string {
        if( !$operators = $this->operators )
            return \Yii::t('app', 'No present' );

        if( !is_array( $operators ) )
            $operators = [ $operators ];

        $label = '';
        /** @var User $operator */
        foreach( $operators as $operator )
            $label .= $operator->username . ' (' . $operator->email . '), ';

        return trim( $label, ',\ ' );
    }

    /**
     * @return array|PartyQuery|Party|null
     */
    public static function findCurrent() {
        $party = static::find()->where(['>', 'timestamp', time()])
            ->active()->orderBy('timestamp')->one();

        return $party ?: new Party();
    }

    /**
     * @param array $condition
     * @return BaseModel|null
     */
    public static function findActiveOne( array $condition ) {
        $condition['closed'] = 0;
        return parent::findOne( $condition );
    }

    /**
     * {@inheritdoc}
     * @return PartyQuery the active query used by this AR class.
     */
    public static function find() {
        return new PartyQuery( get_called_class() );
    }
}
