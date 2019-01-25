<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ticket`.
 */
class m190124_184619_create_ticket_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $table = 'ticket';
        $this->createTable( $table, [
            'id'        => $this->primaryKey(),
            'party_id'  => $this->integer()->notNull()->comment('Ticket party ID'),
            'member_id' => $this->integer()->notNull()->comment('Ticket member ID'),
            'comment'   => $this->text()->null()->comment('Operator comments'),
            'visited'   => $this->tinyInteger(1)
                ->notNull()->defaultValue(0)->comment('Is party visited by member flag'),
            'paid'      => $this->integer()->null()->comment('How much member paid for party'),
            'is_blocked'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is ticket blocked for use'),
            'closed'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is ticket closed'),
            'updated_by'    => $this->integer()->notNull()->comment('Who make last ticket updates'),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
        $this->createIndex( "idx-$table-party_id", $table,  'party_id' );
        $this->createIndex( "idx-$table-member_id", $table,  'member_id' );
        $this->createIndex( "idx-$table-updated_by", $table,  'updated_by' );
        // add foreign key for table `member`
        $this->addForeignKey(
            "fk-$table-member_id",
            $table, 'member_id',
            'member', 'id'
        );
        // add foreign key for table `party`
        $this->addForeignKey(
            "fk-$table-party_id",
            $table, 'party_id',
            'party', 'id'
        );
        // add foreign key for table `party`
        $this->addForeignKey(
            "fk-$table-updated_by",
            $table, 'updated_by',
            'user', 'id'
        );
        // create unique member party key:
        $this->createIndex(
            "idx-unique-$table", $table,
            ['member_id', 'party_id'], true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $table = 'ticket';
        $this->dropForeignKey( "fk-$table-member_id", $table );
        $this->dropForeignKey( "fk-$table-party_id", $table );
        $this->dropForeignKey( "fk-$table-updated_by", $table );
        // drops indexes for columns
        $this->dropIndex( "idx-unique-$table", $table );
        $this->dropIndex( "idx-$table-member_id", $table );
        $this->dropIndex( "idx-$table-party_id", $table );
        $this->dropIndex( "idx-$table-updated_by", $table );
        $this->dropTable( $table );
    }
}
