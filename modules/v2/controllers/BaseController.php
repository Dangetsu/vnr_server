<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use app\modules\v2\models\User;

class BaseController extends ActiveController {

    const PUT_METHOD = 'PUT';

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
                    'password' => $this->_generatePasswordHash($password),
                ]);
            },
        ];
        return $behaviors;
    }

    /**
     * @param string $password
     * @return string
     */
    protected function _generatePasswordHash($password) {
        return md5(md5($password));
    }
}