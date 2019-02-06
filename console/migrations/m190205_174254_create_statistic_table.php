<?php
use yii\db\Migration;

/**
 * Handles the creation of table `statistic`.
 */
class m190205_174254_create_statistic_table extends Migration {

    protected $table = 'statistic';
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $table = $this->table;
        $this->createTable( $table, [
            'id'            => $this->primaryKey(),
            'date'          => $this->date()->notNull(),
            'ask_make'      => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'ask_reject'    => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'ask_member'    => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'ask_accept'    => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'party_close'   => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'ticket_close'  => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'member_visit'  => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'member_pay'    => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'operator_id'   => $this->integer()->notNull()
        ]);

        $this->createIndex("idx-$table-operator", $table, 'operator_id' );
        $this->addForeignKey("fk-$table-operator",
            $table, 'operator_id',
        'user', 'id'
        );
        $this->createIndex("idx-$table-data-operator", $table, ['date', 'operator_id'], true );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $table = $this->table;
        $this->dropIndex("idx-$table-data-operator", $table );
        $this->dropForeignKey("fk-$table-operator", $table );
        $this->dropIndex("idx-$table-operator", $table );
        $this->dropTable( $table );
    }
}
