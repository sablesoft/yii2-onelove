<?php
use yii\db\Migration;

/**
 * Class m190207_081143_add_views_statistic_fields
 */
class m190207_081143_add_views_statistic_fields extends Migration {
    /** @var string $table */
    protected $table = 'statistic';
    /** @var array $fields - all fields with new */
    protected $fields = [
        'view_desc', 'view_mobile',
        'ask_make', 'ask_reject', 'ask_member', 'ask_accept',
        'party_close', 'ticket_close', 'member_visit', 'member_pay'
    ];
    /** @var array $newFields - new fields for install */
    protected $newFields = [ 'view_desc' => 'date', 'view_mobile' => 'view_desc' ];

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $table = $this->table;
        // create views fields:
        foreach( $this->newFields as $field => $after )
            $this->addColumn( $table, $field,
                $this->integer()->unsigned()->notNull()
                    ->defaultValue( 0 )->after( $after )
            );
        // add indexes for all:
        foreach( $this->fields as $field )
            $this->createIndex( "idx-$table-$field", $table, $field );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $table = $this->table;
        // drop indexes for all:
        foreach( $this->fields as $field )
            $this->dropIndex( "idx-$table-$field", $table );
        // create views fields:
        foreach( $this->newFields as $field => $after )
            $this->dropColumn( $table, $field );
    }
}
