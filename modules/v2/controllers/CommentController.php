<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

use app\modules\v2\models;
use yii\web;

class CommentController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Comment';

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