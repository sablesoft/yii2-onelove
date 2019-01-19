<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member_party`.
 */
class m190118_201038_create_party_member_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('party_member', [
            'id'        => $this->primaryKey(),
            'party_id'  => $this->integer()->notNull(),
            'member_id' => $this->integer()->notNull(),
            'visited'   => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'paid'      => $this->integer()->null()
        ]);
        $this->createIndex( 'idx-party_member-member_id', 'party_member',  'member_id' );
        $this->createIndex( 'idx-party_member-party_id', 'party_member',  'party_id' );
        $this->createIndex( 'idx-party_member-visited', 'party_member',  'visited' );
        $this->createIndex( 'idx-party_member-paid', 'party_member',  'paid' );
        // add foreign key for table `member`
        $this->addForeignKey(
            'fk-party_member-member_id',
            'party_member', 'member_id',
            'member', 'id'
        );
        // add foreign key for table `party`
        $this->addForeignKey(
            'fk-party_member-party_id',
            'party_member', 'party_id',
            'party', 'id'
        );
        // create unique member party key:
        $this->createIndex(
            'idx-unique-party_member', 'party_member',
            ['member_id', 'party_id'], true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for tables `member` and `party`
        $this->dropForeignKey( 'fk-party_member-member_id', 'party_member' );
        $this->dropForeignKey( 'fk-party_member-party_id', 'party_member' );
        // drops indexes for columns
        $this->dropIndex( 'idx-unique-party_member', 'party_member' );
        $this->dropIndex( 'idx-party_member-member_id', 'party_member' );
        $this->dropIndex( 'idx-party_member-party_id', 'party_member' );
        $this->dropIndex( 'idx-party_member-visited', 'party_member' );
        $this->dropIndex( 'idx-party_member-paid', 'party_member' );
        // drop table:
        $this->dropTable('party_member');
    }
}
