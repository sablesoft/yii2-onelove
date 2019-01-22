<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id
 * @property string $label Setting label
 * @property string $key Setting programmer code unique key
 * @property string $value Setting value
 * @property string $description Setting description
 * @property bool $isCheckDefault
 */
class Setting extends \yii\db\ActiveRecord {

    /** @var integer */
    protected $checkDefault;

    /**
     * @return bool
     */
    public function getIsCheckDefault() : bool {
        return (bool) $this->checkDefault;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['label', 'key'], 'required'],
            [['description', 'value'], 'string'],
            [['label'], 'string', 'max' => 30],
            [['key'], 'string', 'max' => 30],
            [['label'], 'unique'],
            [['key'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\SettingQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\SettingQuery(get_called_class());
    }
}
