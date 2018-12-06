<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Reference extends Base {
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
            [['type', 'user_hash', 'key', 'url', 'title', 'brand', 'comment', 'update_comment'], 'string'],
            [['item_id', 'game_id', self::USER_ID_LABEL, self::UPDATE_USER_ID_LABEL, self::TIMESTAMP_LABEL, self::UPDATE_TIMESTAMP_LABEL, 'date'], 'integer'],
            [['disabled', self::DELETED_LABEL], 'boolean'],
        ];
    }
}