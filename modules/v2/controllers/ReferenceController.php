<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models;
use yii\web;
use yii\base;

class ReferenceController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Reference';

    /**
     * @param int $id
     * @return models\Reference
     * @throws base\InvalidConfigException
     * @throws web\ServerErrorHttpException
     */
    public function actionDelete($id) {
        /** @var models\Reference $modelClass */
        $modelClass = $this->modelClass;
        $model = $modelClass::findOne(['id' => $id]);
        $this->_saveModel($model, [$model::DELETED_LABEL => 1]);
        return $model;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function _prepareParamsForCreateItem(array $params = []) {
        $result = parent::_prepareParamsForCreateItem($params);
        /** @var models\Reference $model */
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
        /** @var models\Reference $model */
        $model = new $this->modelClass();
        $result[$model::UPDATE_USER_ID_LABEL] = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 'NULL';
        $result[$model::UPDATE_TIMESTAMP_LABEL] = (new \DateTime())->getTimestamp();
        unset($result[$model::USER_ID_LABEL], $result[$model::TIMESTAMP_LABEL]);
        return $result;
    }
}