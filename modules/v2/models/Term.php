<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Term extends Base {

    const USER_ID_LABEL = 'user_id';
    const PRIVATE_LABEL = 'private';
    const DELETED_LABEL = 'deleted';
    const UPDATE_USER_ID_LABEL = 'update_user_id';
    const TIMESTAMP_LABEL = 'timestamp';
    const UPDATE_TIMESTAMP_LABEL = 'update_timestamp';

    /**
     * @return array
     */
    public function rules() {
        return [
            [['type', 'language', 'source_language', 'host', 'context', 'priority', 'role', 'pattern', 'text', 'ruby', 'comment', 'update_comment', 'user_hash'], 'string'],
            [['game_id', self::USER_ID_LABEL, self::TIMESTAMP_LABEL, self::UPDATE_TIMESTAMP_LABEL, self::UPDATE_USER_ID_LABEL], 'integer'],
            [['special', self::PRIVATE_LABEL, 'hentai', 'regex', 'phrase', 'icase', 'disable', self::DELETED_LABEL], 'boolean'],
        ];
    }
}