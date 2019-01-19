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
            'name'          => $this->string(40)->notNull()->unique(),
            'address'       => $this->string(100)->notNull()->unique(),
            'phone'         => $this->string(20)->null(),
            'map'           => $this->text()->null(),
            'photo'         => $this->string(40)->null(),
            'is_default'    => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropTable('place');
    }
}
