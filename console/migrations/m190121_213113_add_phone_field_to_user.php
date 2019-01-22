<?php
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190121_213113_add_phone_field_to_user
 */
class m190121_213113_add_phone_field_to_user extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%user}}', 'phone', Schema::TYPE_STRING );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%user}}', 'phone');
    }
}
