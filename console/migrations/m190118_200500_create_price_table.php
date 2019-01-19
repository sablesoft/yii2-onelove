<?php

use yii\db\Migration;

/**
 * Handles the creation of table `price`.
 */
class m190118_200500_create_price_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('price', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(30)->notNull(),
            'base'          => $this->integer()->notNull(),
            'repeat'        => $this->integer()->notNull(),
            'company'       => $this->integer()->notNull(),
            'is_default'    => $this->tinyInteger(1)->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('price');
    }
}
