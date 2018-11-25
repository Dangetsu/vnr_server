<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use app\modules\v2\models\User;

class BaseController extends ActiveController {
    /**
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'only' => ['me'],
            'auth' => function ($username, $password) {
                return User::findOne([
                    'name' => $username,
                    'password' => $password,
                ]);
            },
        ];
        return $behaviors;
    }
}