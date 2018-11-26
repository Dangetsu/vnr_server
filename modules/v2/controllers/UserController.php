<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models\User;
use yii\db\ActiveRecord;

class UserController extends BaseController {
    /**
     * @var string
     */
    public $modelClass = 'app\modules\v2\models\User';

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        unset($actions['delete'], $actions['create']);
        return $actions;
    }

    /**
     * @return User
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionMe() {
        $model = User::findIdentity(\Yii::$app->user->getId());
        if ($_SERVER['REQUEST_METHOD'] === self::PUT_METHOD) {
            $this->_saveModel($model);
        }
        return $model;
    }

    /**
     * @return ActiveRecord
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function actionCreate() {
        $model = new User();
        $params = \Yii::$app->getRequest()->getBodyParams();
        $params['password'] = $this->_generatePasswordHash($params['password']);
        $this->_saveModel($model, $params);
        return $model;
    }

    /**
     * @param ActiveRecord $model
     * @param array $params
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    private function _saveModel(ActiveRecord $model, array $params = []) {
        if (count($params) === 0) {
            $params = \Yii::$app->getRequest()->getBodyParams();
        }
        $model->load($params, '');
        $isSave = $model->save();
        if ($isSave === false && !$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Failed to save the object for unknown reason.');
        }
    }
}