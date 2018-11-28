<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Term extends Base {
    /**
     * @return array
     */
    public function rules() {
        return [
            [['type', 'language', 'source_language', 'host', 'context', 'priority', 'role', 'pattern', 'text', 'ruby', 'comment', 'update_comment', 'user_hash'], 'string'],
            [['game_id', 'user_id', 'timestamp', 'update_timestamp', 'update_user_id'], 'integer'],
            [['special', 'private', 'hentai', 'regex', 'phrase', 'icase', 'disable', 'deleted'], 'boolean'],
        ];
    }
}