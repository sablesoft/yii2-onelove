<?php
namespace common\models;

use yii\base\Model;
use common\behavior\NameBehavior;
use common\behavior\PhoneBehavior;

/**
 * Class CallForm
 * @package common\models
 *
 * @property string $name
 * @property string $phone
 * @property string $label
 * @property int $created_at
 * @property string $maskedPhone
 * @property array $maskedPhoneConfig
 */
class CallForm extends Model {

    public $name;
    public $phone;
    public $created_at;

    /**
     * CallForm constructor.
     * @param array $config
     */
    public function __construct( array $config = []) {
        parent::__construct( $config );
        $this->created_at = date('Y-m-d H:i' );
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'phone'], 'required'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 20 ],
            [['name'], 'validateName'],
            [['phone'], 'validatePhone']
        ];
    }

    /**
     * @return array
     */
    public function behaviors() {
        return array_merge( parent::behaviors(), [
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
            'name' => \Yii::t('app', 'Name'),
            'phone' => \Yii::t('app', 'Phone'),
            'maskedPhone' => \Yii::t('app', 'Phone'),
            'created_at' => \Yii::t('app', 'Created At')
        ];
    }

    /**
     * @return string
     */
    public function getLabel(): string {
        return $this->name . ': ' . $this->maskedPhone;
    }
}
