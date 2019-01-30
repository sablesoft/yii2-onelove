<?php
use yii\db\Migration;
use common\models\Ask;
use common\models\Group;
use common\models\Member;

/**
 * Handles the creation of table `group`.
 */
class m190129_130643_create_group_table extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->createTable('group', [
            'id'            => $this->primaryKey(),
            'label'         => $this->string(20)->notNull()->comment('Age search group label'),
            'rule'          => $this->string(10)->notNull()->comment('Age search group rule'),
            'is_blocked'    => $this->integer(1)->notNull()->defaultValue(0)->comment('Age search group is blocked flag'),
            'description'   => $this->text()->null()->comment('Age search group description'),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull()
        ]);
        $ask = Ask::tableName();
        // create column, index and foreign key for ask table:
        $this->addColumn( $ask, "group_id",
            $this->integer()->null()->after("sex")->comment("Age search group ID")
        );
        $this->createIndex( "idx-$ask-group_id", $ask, "group_id" );
        $this->addForeignKey( "fk-$ask-group_id",
            $ask, "group_id",
            Group::tableName(), "id"
        );
        $member = Member::tableName();
        // create column, index and foreign key for member table:
        $this->addColumn( $member, "group_id",
            $this->integer()->null()->after("sex")->comment("Age search group ID")
        );
        $this->createIndex( "idx-$member-group_id", $member, "group_id" );
        $this->addForeignKey( "fk-$member-group_id",
            $member, "group_id",
            Group::tableName(), "id"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        // drop foreign key, index and column group_id in member table:
        $member = Member::tableName();
        $this->dropForeignKey("fk-$member-group_id", $member );
        $this->dropIndex("idx-$member-group_id", $member );
        $this->dropColumn( $member, "group_id" );
        // drop foreign key, index and column group_id in ask table:
        $ask = Ask::tableName();
        $this->dropForeignKey("fk-$ask-group_id", $ask );
        $this->dropIndex("idx-$ask-group_id", $ask );
        $this->dropColumn( $ask, "group_id" );

        $this->dropTable("group");
    }
}
