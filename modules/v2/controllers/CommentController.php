<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models;
use yii\web;
use yii\base;

// todo: fix DRY
class CommentController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Comment';

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        unset($actions[self::ACTION_DELETE], $actions[self::ACTION_CREATE], $actions[self::ACTION_UPDATE]);
        return $actions;
    }

    /**
     * @return models\Comment
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionCreate() {
        /** @var models\Comment $model */
        $model = new $this->modelClass();
        $params = \Yii::$app->getRequest()->getBodyParams();
        $params[$model::USER_ID_LABEL] = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 'NULL';
        $params[$model::TIMESTAMP_LABEL] = (new \DateTime())->getTimestamp();
        $this->_saveModel($model, $params);
        return $model;
    }

    /**
     * @param int $id
     * @return models\Comment
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionUpdate($id) {
        /** @var models\Comment $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['id' => $id]);
        $params = \Yii::$app->getRequest()->getBodyParams();
        $params[$model::UPDATE_USER_ID_LABEL] = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 'NULL';
        $params[$model::UPDATE_TIMESTAMP_LABEL] = (new \DateTime())->getTimestamp();
        unset($params[$model::USER_ID_LABEL], $params[$model::TIMESTAMP_LABEL]);
        $this->_saveModel($model, $params);
        return $model;
    }

    /**
     * @param int $id
     * @return models\Comment
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionDelete($id) {
        /** @var models\Comment $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['id' => $id]);
        $this->_saveModel($model, [$model::DELETED_LABEL => 1]);
        return $model;
    }

    /**
     * @param string $action
     * @param models\Comment $model
     * @param array $params
     * @throws web\ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = []) {
        if ($model === null) {
            return;
        }

        $isLockedComment = (bool) $model->{$model::LOCKED_LABEL};
        if ($isLockedComment && !$this->_isOwnItem($model) && !$this->_canUserEditComments()) {
            throw new web\ForbiddenHttpException('Access denied!');
        }
    }
}