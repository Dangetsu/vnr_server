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
            $userId = \Yii::$app->user->getId() !== null ? \Yii::$app->user->getId() : 0;
            $query->andWhere([
                'or',
                $modelClass::USER_ID_LABEL . " = {$userId}",
                $modelClass::PRIVATE_LABEL . " = 0",
            ]);
        }
        return $query;
    }
}