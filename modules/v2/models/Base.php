<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

use yii\db;

abstract class Base extends db\ActiveRecord {
    protected function _convertToCamelFormat($input, $separator = '_') {
        return str_replace($separator, '', lcfirst(ucwords($input, $separator)));
    }
}