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
            'name'          => $this->string(30)
                ->notNull()->comment('Price list label'),
            'base'          => $this->integer()->notNull()->comment('Base price'),
            'repeat'        => $this->integer()->notNull()
                ->comment('Price for repeat visit'),
            'company'       => $this->integer()->notNull()
                ->comment('Price for members company'),
            'is_blocked'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is price list blocked for use'),
            'is_default'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is default price list flag'),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('price');
    }
}
