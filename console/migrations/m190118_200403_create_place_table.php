<?php

use yii\db\Migration;

/**
 * Handles the creation of table `place`.
 */
class m190118_200403_create_place_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('place', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(40)
                ->notNull()->unique()->comment('Place name'),
            'address'       => $this->string(100)
                ->notNull()->unique()->comment('Price address'),
            'phone'         => $this->string(20)->null()
                ->comment('Place manager phone number'),
            'map'           => $this->text()->null()
                ->comment('Place map javascript'),
            'photo'         => $this->string(40)->null()
                ->comment('Place photo web-path'),
            'is_blocked'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is party place blocked for use'),
            'is_default'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is default party place flag'),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('place');
    }
}
