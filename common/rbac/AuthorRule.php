<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */
namespace app\common\rbac;

use yii\rbac;

class AuthorRule extends rbac\Rule {
    public $name = 'isAuthor';

    /**
     * @param int $userId
     * @param rbac\Item $item
     * @param object $params
     * @return bool
     */
    public function execute($userId, $item, $params) {
        return $params->user_id === $userId;
    }
}