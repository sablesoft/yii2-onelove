<?php

use yii\db\Migration;

/**
 * Handles the creation of table `party`.
 */
class m190118_200537_create_party_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('party', [
            'id'            => $this->primaryKey(),
            'place_id'      => $this->integer()->notNull(),
            'price_id'      => $this->integer()->notNull(),
            'timestamp'     => $this->timestamp()->notNull(),
            'description'   => $this->text()->null(),
            'created_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
        // creates indexes for columns `place_id`, 'timestamp', 'requests', 'members'...
        $this->createIndex( 'idx-party-place_id', 'party',  'place_id' );
        $this->createIndex( 'idx-party-price_id', 'party',  'price_id' );
        $this->createIndex( 'idx-party-timestamp', 'party',  'timestamp' );
        // add foreign key for table `place`
        $this->addForeignKey(
            'fk-party-place_id',
            'party', 'place_id',
            'place', 'id'
        );
        // add foreign key for table `price`
        $this->addForeignKey(
            'fk-party-price_id',
            'party', 'price_id',
            'price', 'id'
        );
        // add unique party place time key:
        $this->createIndex(
            'idx-unique-party-place-time', 'party',
            ['place_id', 'timestamp'], true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for tables `place` and `price`
        $this->dropForeignKey( 'fk-party-place_id', 'party' );
        $this->dropForeignKey( 'fk-party-price_id', 'party' );
        // drops indexes for columns
        $this->dropIndex( 'idx-unique-party-place-time', 'party' );
        $this->dropIndex( 'idx-party-place_id', 'party' );
        $this->dropIndex( 'idx-party-price_id', 'party' );
        $this->dropIndex( 'idx-party-timestamp', 'party' );
        // drop table:
        $this->dropTable('party');
    }
}
