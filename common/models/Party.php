<?php
namespace common\models;

use common\models\query\PartyQuery;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "party".
 *
 * @property int $id
 * @property string $name
 * @property int $place_id
 * @property int $price_id
 * @property string $timestamp
 * @property integer $max_members
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Ask[] $asks
 * @property Place $place
 * @property string $placeLabel
 * @property array $placeUrl
 * @property Price $price
 * @property string $priceLabel
 * @property array $priceUrl
 * @property Member[] $members
 * @property string $formattedTimestamp
 */
class Party extends BaseModel {

    const WIDGET_DATETIME = 'y-m-d H:i';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'party';
    }

    public function behaviors() {
        return [
            [
                'class'      => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['timestamp']
                ],
                'value' => function( $event ) {
                    $timestamp = strtotime( $this->timestamp );
                    return date('Y-m-d H:i', $timestamp );
                }
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['place_id', 'price_id', 'timestamp', 'max_members'], 'required'],
            [['place_id', 'price_id', 'max_members'], 'integer'],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
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
            'priceLabel'  => \Yii::t('app', 'Price'),
            'timestamp' => \Yii::t('app', 'Timestamp'),
            'formattedTimestamp' => \Yii::t('app', 'Timestamp'),
            'max_members'    => \Yii::t('app', 'Max Members'),
            'description' => \Yii::t('app', 'Description'),
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
     * @return string
     */
    public function getPlaceLabel() : string {
        if( !$place = $this->place )
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
     * @return \yii\db\ActiveQuery
     */
    public function getPrice() {
        return $this->hasOne(Price::class, ['id' => 'price_id']);
    }

    /**
     * @return string
     */
    public function getPriceLabel() : string {
        if( !$price = $this->price )
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
     */
    public function getLabel(): string {
        if( $this->name )
            return $this->name;

        return $this->placeLabel . ' - ' . $this->formattedTimestamp;
    }

    public function getFormattedTimestamp( $format = self::WIDGET_DATETIME ) : string {
        return date( $format, strtotime( $this->timestamp ) );
    }

    /**
     * {@inheritdoc}
     * @return PartyQuery the active query used by this AR class.
     */
    public static function find() {
        return new PartyQuery( get_called_class() );
    }
}
