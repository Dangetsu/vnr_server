<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

use yii\db;

abstract class Base extends db\ActiveRecord {
    const CAMEL_CASE_PARAM = 'camel_format';

    /**
     * @return array
     */
    public function fields() {
        return (bool) \Yii::$app->getRequest()->getQueryParam(self::CAMEL_CASE_PARAM) ? $this->_convertFieldsToCamelFormat(parent::fields()) : parent::fields();
    }

    /**
     * @param array $fields
     * @param string $separator
     * @return array
     */
    protected function _convertFieldsToCamelFormat(array $fields, $separator = '_') {
        $result = [];
        foreach ($fields as $key => $value) {
            $key = str_replace($separator, '', lcfirst(ucwords($key, $separator)));
            $result[$key] = $value;
        }
        return $result;
    }
}