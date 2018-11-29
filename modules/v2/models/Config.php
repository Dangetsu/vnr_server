<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Config extends Base {
    /**
     * @return array
     */
    public function rules() {
        return [
            [['md5', 'names', 'encoding', 'language', 'hook', 'thread_name', 'thread_signature', 'name_thread_name', 'name_thread_signature'], 'string'],
            [['item_id', 'visit_count', 'comment_count', 'update_user_id', 'update_timestamp'], 'integer'],
            [['delete_hook', 'thread_kept', 'keeps_space', 'removes_repeat', 'ignores_repeat', 'name_thread_disabled', 'freezed'], 'boolean'],
        ];
    }
}