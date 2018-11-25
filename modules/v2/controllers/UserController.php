<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models\User;

class UserController extends BaseController {
    public $modelClass = 'app\modules\v2\models\User';

    public function actions() {
        $actions = parent::actions();
        unset( $actions['delete']);
        return $actions;
    }

    public function actionMe() {
        return User::findIdentity(\Yii::$app->user->getId());
    }
}