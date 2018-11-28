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
        $auth->removeAll();

        $user = $auth->createRole('user');
        $auth->add($user);

        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $editComments = $auth->createPermission('editComments');
        $auth->add($editComments);

        $editTerms = $auth->createPermission('editTerms');
        $auth->add($editTerms);

        $authorRule = new \app\common\rbac\AuthorRule;
        $auth->add($authorRule);
        $updateOwnItem = $auth->createPermission('updateOwnItems');
        $updateOwnItem->ruleName = $authorRule->name;
        $auth->add($updateOwnItem);

        $auth->addChild($user, $updateOwnItem);
        $auth->addChild($admin, $editComments);
        $auth->addChild($admin, $editTerms);
        $auth->addChild($admin, $user);

        $auth->assign($admin, 1);
    }
}