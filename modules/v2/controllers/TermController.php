<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models;
use yii\web;
use yii\base;
use yii\db;

class TermController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Term';

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        unset($actions[self::ACTION_DELETE], $actions[self::ACTION_CREATE], $actions[self::ACTION_UPDATE]);
        return $actions;
    }

    /**
     * @param int $id
     * @return models\Term
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionDelete($id) {
        /** @var models\Term $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['id' => $id]);
        $this->_saveModel($model, [$model::DELETED_LABEL => 1]);
        return $model;
    }

    /**
     * @param string $action
     * @param models\Term $model
     * @param array $params
     * @throws web\ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = []) {
        if ($model === null) {
            return;
        }

        $isPrivateTerm = (bool) $model->{$model::PRIVATE_LABEL};
        if ($isPrivateTerm && !$this->_isOwnItem($model) && !$this->_canUserEditTerms()) {
            throw new web\ForbiddenHttpException('Access denied!');
        }
    }

    /**
     * @param string $modelClass
     * @return db\ActiveQuery
     * @throws base\InvalidConfigException
     */
    protected function _getActiveQuery($modelClass) {
        $query = parent::_getActiveQuery($modelClass);
        /** @var models\Term $modelClass */
        $query->andWhere([$modelClass::DELETED_LABEL => 0]);
        if (!$this->_canUserEditTerms()) {
            $userId = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 'NULL';
            $query->andWhere([
                'or',
                $modelClass::USER_ID_LABEL . " = {$userId}",
                $modelClass::PRIVATE_LABEL . " = 0",
            ]);
        }
        return $query;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function _prepareParamsForCreateItem(array $params = []) {
        $result = parent::_prepareParamsForCreateItem($params);
        /** @var models\Term $model */
        $model = new $this->modelClass();
        $result[$model::USER_ID_LABEL] = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 'NULL';
        $result[$model::TIMESTAMP_LABEL] = (new \DateTime())->getTimestamp();
        return $result;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function _prepareParamsForUpdateItem(array $params = []) {
        $result = parent::_prepareParamsForUpdateItem($params);
        /** @var models\Term $model */
        $model = new $this->modelClass();
        $result[$model::UPDATE_USER_ID_LABEL] = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 'NULL';
        $result[$model::UPDATE_TIMESTAMP_LABEL] = (new \DateTime())->getTimestamp();
        unset($result[$model::USER_ID_LABEL], $result[$model::TIMESTAMP_LABEL]);
        return $result;
    }
}