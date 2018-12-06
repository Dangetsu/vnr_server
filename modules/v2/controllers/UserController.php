<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models;

class UserController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\User';

    /**
     * @return array
     */
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['optional'][] = self::ACTION_CREATE;
        return $behaviors;
    }

    /**
     * @return models\User
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionMe() {
        /** @var models\User $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findIdentity(\Yii::$app->user->getId());
        if (\Yii::$app->getRequest()->getMethod() === self::PUT_METHOD) {
            $this->_saveModel($model);
        }
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function _prepareParamsForCreateItem(array $params = []) {
        $result = parent::_prepareParamsForCreateItem($params);
        /** @var models\User $model */
        $model = new $this->modelClass();
        $result[$model::PASSWORD_LABEL] = $this->_generatePasswordHash($result[$model::PASSWORD_LABEL]);
        return $result;
    }
}