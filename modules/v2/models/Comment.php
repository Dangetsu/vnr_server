<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Comment extends Base {

    const LOCKED_LABEL = 'locked';
    const USER_ID_LABEL = 'user_id';
    const DELETED_LABEL = 'deleted';
    const UPDATE_USER_ID_LABEL = 'update_user_id';
    const TIMESTAMP_LABEL = 'timestamp';
    const UPDATE_TIMESTAMP_LABEL = 'update_timestamp';

    /**
     * @return array
     */
    public function rules() {
        return [
            [['type', 'user_hash', 'language', 'text', 'context', 'context_hash', 'comment', 'update_comment'], 'string'],
            [['game_id', self::USER_ID_LABEL, self::UPDATE_USER_ID_LABEL, self::TIMESTAMP_LABEL, self::UPDATE_TIMESTAMP_LABEL, 'context_size'], 'integer'],
            [[self::LOCKED_LABEL, 'disabled', self::DELETED_LABEL], 'boolean'],
        ];
    }
}