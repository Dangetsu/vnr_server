<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Comment extends Base {
    /**
     * @return array
     */
    public function rules() {
        return [
            [['type', 'user_hash', 'language', 'text', 'context', 'context_hash', 'comment', 'update_comment'], 'string'],
            [['game_id', 'user_id', 'update_user_id', 'timestamp', 'update_timestamp', 'context_size'], 'integer'],
            [['locked', 'disabled', 'deleted'], 'boolean'],
        ];
    }
}