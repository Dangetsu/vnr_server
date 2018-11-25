<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

class UserController extends BaseController {
    public $modelClass = 'app\modules\v2\models\User';

    public function actions()
    {
        $actions = parent::actions();
        unset( $actions['delete']);
        return $actions;
    }
}