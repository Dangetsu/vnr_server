<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

class Game extends Base {
    /**
     * @return array
     */
    public function rules() {
        return [
            [['title', 'romaji_title', 'brand', 'series', 'image', 'banner', 'wiki', 'tags', 'artists', 'writers', 'musicians'], 'string'],
            [[
                'timestamp', 'file_size', 'date', 'annot_count', 'play_user_count', 'scape_median', 'scape_count', 'topic_count',
                'subtitle_count', 'overall_score_count', 'overall_score_sum', 'ecchi_score_count', 'ecchi_score_sum'
            ], 'integer'],
            [['ecchi', 'otome', 'okazu'], 'boolean'],
        ];
    }
}