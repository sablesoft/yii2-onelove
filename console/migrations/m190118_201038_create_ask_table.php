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
            'name'  => $this->string(10)
                ->comment('Client real or nickname'),
            'phone' => $this->string(20)->null()->unique()
                ->comment('Client international format phone number'),
            'age'   => $this->integer()->unsigned()->notNull()
                ->comment('Client age'),
            'sex'   => $this->tinyInteger(1)->notNull()
                ->comment('Client sex flag: Female\Male (0\1)'),
            'created_at'    => $this->integer()->notNull()
        ]);

        $this->createIndex( "idx-$table-phone", $table,  'phone' );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $table = Ask::tableName();
        $this->dropIndex( "idx-$table-phone", $table );
        // drop table:
        $this->dropTable( $table );
    }
}
