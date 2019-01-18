<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member_party`.
 */
class m190118_201038_create_member_party_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('member_party', [
            'id'        => $this->primaryKey(),
            'member_id' => $this->integer()->notNull(),
            'party_id'  => $this->integer()->notNull()
        ]);
        $this->createIndex( 'idx-member_party-member_id', 'member_party',  'member_id' );
        $this->createIndex( 'idx-member_party-party_id', 'member_party',  'party_id' );
        // add foreign key for table `member`
        $this->addForeignKey(
            'fk-member_party-member_id',
            'member_party', 'member_id',
            'member', 'id'
        );
        // add foreign key for table `party`
        $this->addForeignKey(
            'fk-member_party-party_id',
            'member_party', 'party_id',
            'party', 'id'
        );
        // create unique member party key:
        $this->createIndex(
            'idx-unique-member_party', 'member_party',
            ['member_id', 'party_id'], true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for tables `member` and `party`
        $this->dropForeignKey( 'fk-member_party-member_id', 'member_party' );
        $this->dropForeignKey( 'fk-member_party-party_id', 'member_party' );
        // drops indexes for columns
        $this->dropIndex( 'idx-unique-member_party', 'member_party' );
        $this->dropIndex( 'idx-member_party-member_id', 'member_party' );
        $this->dropIndex( 'idx-member_party-party_id', 'member_party' );
        // drop table:
        $this->dropTable('member_party');
    }
}
