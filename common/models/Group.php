<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property string $label Age group label
 * @property string $rule Age group rule
 * @property int $is_blocked Age group is blocked flag
 * @property string $description Age group description
 *
 * @property Ask[] $asks
 * @property Member[] $members
 */
class Group extends CrudModel {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['label', 'rule'], 'required'],
            [['is_blocked'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['label'], 'string', 'max' => 20],
            [['rule'], 'string', 'max' => 10]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
            'rule' => Yii::t('app', 'Rule'),
            'is_blocked' => Yii::t('app', 'Is Blocked'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => \Yii::t('app', 'Created At'),
            'updated_at' => \Yii::t('app', 'Updated At')
        ];
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
        return Yii::t('app', $this->label );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsks() {
        return $this->hasMany(Ask::class, ['group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers() {
        return $this->hasMany(Member::class, ['group_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\GroupQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\query\GroupQuery(get_called_class());
    }
}
