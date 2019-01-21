<?php

namespace common\models;

/**
 * This is the model class for table "price".
 *
 * @property string $name
 * @property int $base
 * @property int $repeat
 * @property int $company
 * @property int $is_default
 *
 * @property Party[] $parties
 */
class Price extends BaseModel {

    protected $checkDefault = true;

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
            [['base', 'repeat', 'company', 'is_default', 'is_blocked'], 'integer'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    public function beforeSave( $insert ) {



        return parent::beforeSave( $insert );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => \Yii::t('app', 'ID'),
            'name' => \Yii::t('app', 'Name'),
            'base' => \Yii::t('app', 'Base'),
            'repeat' => \Yii::t('app', 'Repeat'),
            'company' => \Yii::t('app', 'Company'),
            'is_default' => \Yii::t('app', 'Is Default'),
            'is_blocked' => \Yii::t('app', 'Is Blocked'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParties() {
        return $this->hasMany(Party::class, ['price_id' => 'id']);
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
    public function getLabel() : string {
        return $this->name . ' ( ' . $this->base . ' / ' .
            $this->repeat . ' / ' . $this->company . ' )';
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PriceQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\PriceQuery( get_called_class() );
    }
}
