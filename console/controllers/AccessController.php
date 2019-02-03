<?php
namespace console\controllers;

use Yii;
use common\models\User;
use yii\helpers\Console;
use yii\console\Controller;

/**
 * App access control
 *
 * @package console\controllers
 */
class AccessController extends Controller {

    /**
     * Install app access sql
     */
    public function actionInstall() {
        $path = Yii::getAlias('@console/sql/rbac.sql');
        if( file_exists( $path ) ) {
            try {
                Yii::$app->getDb()->createCommand(
                    file_get_contents($path)
                )->execute();
                // check dev role:
                $auth = Yii::$app->authManager;
                $admin = User::findOne(['username' => 'admin']);
                if( !$auth->checkAccess( $admin->id, 'dev' ) ) {
                    $this->stdout("Apply dev role to admin user!\n", Console::BOLD );
                    $auth->assign( $auth->getRole('dev'), $admin->id );
                }
                // done:
                $this->stdout("Done!\n", Console::BOLD );
            } catch( \Exception $e ) {
                $this->stderr( $e->getMessage() . "\r\n", Console::FG_RED );
            }
        } else {
            $this->stderr( "Rbac sql file not found: $path\r\n", Console::FG_RED );
        }
    }
}
