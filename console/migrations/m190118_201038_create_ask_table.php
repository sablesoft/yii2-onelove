<?php
use yii\db\Migration;
use common\models\Ask;

/**
 * Handles the creation of table `ask`.
 */
class m190118_201038_create_ask_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $table = Ask::tableName();
        $this->createTable( $table, [
            'id'        => $this->primaryKey(),
            'party_id'  => $this->integer()->notNull()->comment('Ask party ID'),
            'member_id' => $this->integer()->notNull()->comment('Ask member ID'),
            'comment'   => $this->text()->null()->comment('Operator comments'),
            'processed' => $this->tinyInteger(1)
                ->notNull()->defaultValue(0)->comment('Is ask processed flag'),
            'confirmed' => $this->tinyInteger(1)
                ->notNull()->defaultValue(0)->comment('Is ask confirmed flag'),
            'visited'   => $this->tinyInteger(1)
                ->notNull()->defaultValue(0)->comment('Is party visited by member flag'),
            'paid'      => $this->integer()->null()->comment('How much member paid for party'),
            'is_blocked'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is ask blocked for use'),
            'closed'    => $this->tinyInteger(1)->notNull()
                ->defaultValue(0)->comment('Is ask closed'),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()

        ]);
        $this->createIndex( 'idx-ask-member_id', $table,  'member_id' );
        $this->createIndex( 'idx-ask-party_id', $table,  'party_id' );
        // add foreign key for table `member`
        $this->addForeignKey(
            'fk-ask-member_id',
            $table, 'member_id',
            'member', 'id'
        );
        // add foreign key for table `party`
        $this->addForeignKey(
            'fk-ask-party_id',
            $table, 'party_id',
            'party', 'id'
        );
        // create unique member party key:
        $this->createIndex(
            'idx-unique-ask', $table,
            ['member_id', 'party_id'], true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $table = Ask::tableName();
        // drops foreign key for tables `member` and `party`
        $this->dropForeignKey( 'fk-ask-member_id', $table );
        $this->dropForeignKey( 'fk-ask-party_id', $table );
        // drops indexes for columns
        $this->dropIndex( 'idx-unique-ask', $table );
        $this->dropIndex( 'idx-ask-member_id', $table );
        $this->dropIndex( 'idx-ask-party_id', $table );
        // drop table:
        $this->dropTable( $table );
    }
}
