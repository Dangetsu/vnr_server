<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use app\modules\v2\models\User;

class BaseController extends ActiveController {

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['class'] = HttpBasicAuth::className();
        $behaviors['authenticator']['auth'] = function ($username, $password) {
            return User::findOne([
                'name' => $username,
                'password' => $password,
            ]);
        };
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }
}