<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Term extends Base {

    const USER_ID_LABEL = 'user_id';
    const PRIVATE_LABEL = 'private';
    const DELETED_LABEL = 'deleted';

    /**
     * @return array
     */
    public function rules() {
        return [
            [['type', 'language', 'source_language', 'host', 'context', 'priority', 'role', 'pattern', 'text', 'ruby', 'comment', 'update_comment', 'user_hash'], 'string'],
            [['game_id', self::USER_ID_LABEL, 'timestamp', 'update_timestamp', 'update_user_id'], 'integer'],
            [['special', self::PRIVATE_LABEL, 'hentai', 'regex', 'phrase', 'icase', 'disable', self::DELETED_LABEL], 'boolean'],
        ];
    }
}