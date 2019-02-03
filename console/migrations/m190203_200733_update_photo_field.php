<?php

use yii\db\Migration;

/**
 * Class m190203_200733_update_photo_field
 */
class m190203_200733_update_photo_field extends Migration {

    const FIELD = 'photo';
    const MEDIA_TABLE = 'imagemanager';

    protected $tables = [ 'member', 'place' ];

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $field = self::FIELD;
        foreach( $this->tables as $table ):
            $this->dropColumn( $table, $field );
            $this->addColumn( $table, $field, $this->integer()
                ->null()->unsigned()->comment('Media photo ID') );
            $this->createIndex( "idx-$table-$field", $table, $field );
            $this->addForeignKey("fk-$table-$field",
                $table, $field, self::MEDIA_TABLE, 'id'
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
            $this->dropIndex( "idx-$table-$field", $table );
            $this->alterColumn( $table, $field,
                $this->string(40)->null()->comment('Photo path')
            );
        endforeach;
    }
}
