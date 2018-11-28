<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models;

class TermController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Term';

    protected function _getActiveQuery($modelClass) {
        $query = parent::_getActiveQuery($modelClass);
        /** @var models\Term $modelClass */
        $query->andWhere([
            'or',
            $modelClass::USER_ID_LABEL . " = ".\Yii::$app->user->getId(),
            $modelClass::PRIVATE_LABEL . " = 0",
        ]);
        return $query;
    }
}