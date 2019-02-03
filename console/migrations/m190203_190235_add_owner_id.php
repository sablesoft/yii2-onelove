<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m190203_190235_add_owner_id
 */
class m190203_190235_add_owner_id extends Migration {

    const FIELD = 'owner_id';

    protected $tables = [
        'ask', 'member', 'group',
        'party', 'place', 'price', 'ticket'
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $field = self::FIELD;
        foreach( $this->tables as $table ):
            $this->addColumn(
                $table, $field,
                $this->integer()->null()->comment('Entity owner ID')
            );
            $this->createIndex("idx-$table-$field", $table, $field );
            $this->addForeignKey("fk-$table-$field",
                $table, $field, User::tableName(), 'id'
            );
        endforeach;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $field = self::FIELD;
        foreach( $this->tables as $table ):
            $this->dropForeignKey("fk-$table-$field", $table );
            $this->dropIndex("idx-$table-$field", $table );
            $this->dropColumn( $table, $field );
        endforeach;
    }
}
