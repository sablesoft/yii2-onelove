<?php
namespace common\models;

use common\models\query\PlaceQuery;

/**
 * This is the model class for table "place".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property string $map
 * @property string $photo
 * @property int $is_default
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Party[] $parties
 */
class Place extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            // todo validate photo path
            [['name', 'address'], 'required'],
            [['is_default'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'photo'], 'string', 'max' => 40],
            [['address'], 'string', 'max' => 100],
            [['map'], 'string'],
            [['phone'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['address'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'address' => \Yii::t('app', 'Address'),
            'phone' => \Yii::t('app', 'Phone'),
            'map' => \Yii::t('app', 'Map'),
            'photo' => \Yii::t('app', 'Photo'),
            'is_default' => \Yii::t('app', 'Is Default'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParties() {
        return $this->hasMany(Party::class, ['place_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PlaceQuery the active query used by this AR class.
     */
    public static function find() {
        return new PlaceQuery( get_called_class() );
    }
}
