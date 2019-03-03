<?php

use yii\db\Migration;

/**
 * Class m190303_102827_add_photo_order_field
 */
class m190303_102827_add_photo_order_field extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->addColumn('{{%g_photo}}', 'order', $this->integer()->unsigned()->null() );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->dropColumn('{{%g_photo}}', 'order');
    }
}
