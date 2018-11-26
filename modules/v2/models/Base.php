<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

use yii\db;

abstract class Base extends db\ActiveRecord {
    protected function _convertFieldsToCamelFormat(array $fields, $separator = '_') {
        $result = [];
        foreach ($fields as $key => $value) {
            $key = str_replace($separator, '', lcfirst(ucwords($key, $separator)));
            $result[$key] = $value;
        }
        return $result;
    }
}