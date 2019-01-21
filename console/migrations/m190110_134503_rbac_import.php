<?php
use yii\db\Migration;

/**
 * Class m190110_134503_rbac_import
 */
class m190110_134503_rbac_import extends Migration {
    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $path = Yii::getAlias('@console/sql/rbac.sql');
        if( file_exists( $path ) ) {
//            echo file_get_contents( $path );
            $this->execute( file_get_contents( $path ) );

            return true;
        } else {
            echo "Rbac sql file not found: $path";

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m190121_134503_rbac_import cannot be reverted.\n";
    }
}
