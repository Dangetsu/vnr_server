<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

class ConfigController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Config';

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        unset($actions[self::ACTION_DELETE]);
        return $actions;
    }
}