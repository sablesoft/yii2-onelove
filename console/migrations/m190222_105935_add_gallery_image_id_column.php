<?php

use yii\db\Migration;

/**
 * Class m190222_105935_add_gallery_image_id_column
 */
class m190222_105935_add_gallery_image_id_column extends Migration {

    const TABLE = 'g_photo';
    const COLUMN = 'image_id';

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $table = self::TABLE;
        $column = self::COLUMN;
        $this->addColumn( $table, $column, $this->integer()->unsigned()->notNull()->after('gallery_id') );
        $this->addForeignKey("fk-$table-$column", $table,
            'image_id', 'imagemanager', 'id'
        );
        // create unique member party key:
        $this->createIndex(
            "idx-unique-$table", $table,
            ['gallery_id', $column ], true
        );
        $this->alterColumn( $table, 'name', $this->string(20)->null() );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $table = self::TABLE;
        $column = self::COLUMN;
        $this->alterColumn( $table, 'name', $this->string(255)->notNull() );
        $this->dropForeignKey("fk-$table-$column", $table );
        $this->dropIndex( "idx-unique-$table", $table );
        $this->dropColumn( $table, $column );
    }
}
