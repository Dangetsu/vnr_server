<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models\User;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

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
        unset($actions['delete']);
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
            $this->_updateMe($model);
        }
        return $model;
    }

    /**
     * @param string $action
     * @param Model $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = []) {
        if ($action === 'update' && \Yii::$app->user->getId() !== $model->id) {
            throw new ForbiddenHttpException('fuck!');
        }


    }

    /**
     * @param User $model
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ServerErrorHttpException
     */
    private function _updateMe(User $model) {
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        $isSave = $model->save();
        if ($isSave === false && !$model->hasErrors()) {
            throw new \yii\web\ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
    }
}