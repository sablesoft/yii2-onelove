<?php

namespace common\models;

/**
 * This is the model class for table "price".
 *
 * @property int $id
 * @property string $name
 * @property int $base
 * @property int $repeat
 * @property int $company
 * @property int $is_default
 *
 * @property Party[] $parties
 */
class Price extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'base', 'repeat', 'company'], 'required'],
            [['base', 'repeat', 'company', 'is_default'], 'integer'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'base' => 'Base',
            'repeat' => 'Repeat',
            'company' => 'Company',
            'is_default' => 'Is Default'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParties() {
        return $this->hasMany(Party::class, ['price_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PriceQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\PriceQuery( get_called_class() );
    }
}
