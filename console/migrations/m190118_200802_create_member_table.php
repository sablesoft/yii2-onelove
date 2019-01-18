<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m190118_200802_create_member_table extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('member', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer()->null()->unique(),
            'name'          => $this->string(10),
            'age'           => $this->integer()->unsigned()->notNull(),
            'dob'           => $this->timestamp()->null(),
            'sex'           => $this->tinyInteger(1)->notNull(),
            'phone'         => $this->string(20)->null()->unique(),
            'email'         => $this->string(20)->null()->unique(),
            'resume'        => $this->text()->null(),
            'created_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at'    => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
        // creates indexes for columns `place_id`, 'timestamp', 'requests', 'members'...
        $this->createIndex( 'idx-member-user_id', 'member',  'user_id' );
        $this->createIndex( 'idx-member-age', 'member',  'age' );
        $this->createIndex( 'idx-member-dob', 'member',  'dob' );
        $this->createIndex( 'idx-member-sex', 'member',  'sex' );
        $this->createIndex( 'idx-member-phone', 'member',  'phone' );
        $this->createIndex( 'idx-member-email', 'member',  'email' );
        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-member-user_id',
            'member', 'user_id',
            'user', 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drops foreign key for table `place`
        $this->dropForeignKey( 'fk-member-user_id', 'member' );
        // drops indexes for columns
        $this->dropIndex( 'idx-member-user_id', 'member' );
        $this->dropIndex( 'idx-member-age', 'member' );
        $this->dropIndex( 'idx-member-dob', 'member' );
        $this->dropIndex( 'idx-member-sex', 'member' );
        $this->dropIndex( 'idx-member-phone', 'member' );
        $this->dropIndex( 'idx-member-email', 'member' );
        // drop table:
        $this->dropTable('member');
    }
}
