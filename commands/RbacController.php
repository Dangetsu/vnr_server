<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller {
    /**
     * @throws \Exception
     */
    public function actionInit() {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $editComments = $auth->createPermission('editComments');
        $auth->add($editComments);

        $editTerms = $auth->createPermission('editTerms');
        $auth->add($editTerms);

        $auth->addChild($admin, $editComments);
        $auth->addChild($admin, $editTerms);
        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);
    }
}