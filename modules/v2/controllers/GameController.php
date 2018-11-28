<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\controllers;

class GameController extends BaseController {
    /** @var string */
    public $modelClass = 'app\modules\v2\models\Game';

    /**
     * @return array
     */
    public function actions() {
        $actions = parent::actions();
        unset($actions[self::ACTION_DELETE]);
        return $actions;
    }
}