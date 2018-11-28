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
    public function actions() {
        $actions = parent::actions();
        unset($actions[self::ACTION_DELETE], $actions[self::ACTION_CREATE], $actions[self::ACTION_UPDATE]);
        return $actions;
    }

    /**
     * @return models\User
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionMe() {
        $model = models\User::findIdentity(\Yii::$app->user->getId());
        if (\Yii::$app->getRequest()->getMethod() === self::PUT_METHOD) {
            $this->_saveModel($model);
        }
        return $model;
    }

    /**
     * @return \yii\db\ActiveRecord
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionCreate() {
        $model = new models\User();
        $params = \Yii::$app->getRequest()->getBodyParams();
        $params[$model::PASSWORD_LABEL] = $this->_generatePasswordHash($params[$model::PASSWORD_LABEL]);
        $this->_saveModel($model, $params);
        return $model;
    }
}