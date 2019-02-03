<?php
use yii\db\Migration;
use common\models\Ask;
use common\models\Group;
use common\models\Member;

/**
 * Class m190129_140711_install_group_data
 */
class m190129_140711_install_group_data extends Migration {

    /**
     * @var array
     */
    protected $groups = [
        [
            'label'     => 'Irrelevant',
            'rule'      => '*',
            'description'   => 'Irrelevant'
        ],
        [
            'label'     => 'My age',
            'rule'      => '!3',
            'description'   => 'My age'
        ],
        [
            'label'     => 'Younger than me',
            'rule'      => '<*',
            'description'   => 'Younger than me'
        ],
        [
            'label'     => 'Older than me',
            'rule'      => '>*',
            'description'   => 'Older than me'
        ],
        [
            'label'     => 'From 18 to 28',
            'rule'      => '18-28',
            'description'   => 'From 18 to 28'
        ],
        [
            'label'     => 'From 26 to 38',
            'rule'      => '26-38',
            'description'   => 'From 26 to 38'
        ],
        [
            'label'     => 'From 36 to 48',
            'rule'      => '36-48',
            'description'   => 'From 36 to 48'
        ],
        [
            'label'     => 'From 46',
            'rule'      => '46-',
            'description'   => 'From 46'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        // install default groups:
        foreach( $this->groups as $groupData ) {
            $group = new Group( $groupData );
            $group->label = Yii::t('app', $group->label );
            $group->save();
        }

        $group = Group::findOne(['rule' => '*']);
        $id = $group->id;

        $this->alterColumn( Ask::tableName(), 'group_id',
            $this->integer()->notNull()->defaultValue( $id )->after("sex")->comment("Age search group ID")
        );

        $this->alterColumn( Member::tableName(), 'group_id',
            $this->integer()->notNull()->defaultValue( $id )->after("sex")->comment("Age search group ID")
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->alterColumn( Ask::tableName(), 'group_id',
            $this->integer()->null()->defaultValue(null)->after("sex")->comment("Age search group ID")
        );
        $this->alterColumn( Member::tableName(), 'group_id',
            $this->integer()->null()->defaultValue(null)->after("sex")->comment("Age search group ID")
        );

        return true;
    }
}
