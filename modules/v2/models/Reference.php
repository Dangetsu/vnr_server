<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Reference extends Base {
    /**
     * @return array
     */
    public function rules() {
        return [
            [['type', 'user_hash', 'key', 'url', 'title', 'brand', 'comment', 'update_comment'], 'string'],
            [['item_id', 'game_id', 'user_id', 'update_user_id', 'timestamp', 'update_timestamp', 'date'], 'integer'],
            [['disabled', 'deleted'], 'boolean'],
        ];
    }
}