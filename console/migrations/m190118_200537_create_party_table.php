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
            'time'          => $this->string(5)->notNull(),
            'date'          => $this->string(8)->notNull(),
            'timestamp'     => $this->timestamp()->notNull(),
            'requests'      => $this->integer()->unsigned(),
            'members'       => $this->integer()->unsigned(),
            'created_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
        // creates indexes for columns `place_id`, 'timestamp', 'requests', 'members'...
        $this->createIndex( 'idx-party-place_id', 'party',  'place_id' );
        $this->createIndex( 'idx-party-timestamp', 'party',  'timestamp' );
        $this->createIndex( 'idx-party-requests', 'party',  'requests' );
        $this->createIndex( 'idx-party-members', 'party',  'members' );
        // add foreign key for table `place`
        $this->addForeignKey(
            'fk-party-place_id',
            'party', 'place_id',
            'place', 'id'
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
        // drops foreign key for table `place`
        $this->dropForeignKey( 'fk-party-place_id', 'party' );
        // drops indexes for columns `category_id`
        $this->dropIndex( 'idx-unique-party-place-time', 'party' );
        $this->dropIndex( 'idx-party-place_id', 'party' );
        $this->dropIndex( 'idx-party-timestamp', 'party' );
        $this->dropIndex( 'idx-party-requests', 'party' );
        $this->dropIndex( 'idx-party-members', 'party' );
        // drop table:
        $this->dropTable('party');
    }
}
