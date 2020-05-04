<?php

namespace app\modules\v2;

use yii;

class CustomResponse extends yii\web\Response {

    /**
     * @return array
     */
    protected function defaultFormatters() {
        $formatters = parent::defaultFormatters();
        $formatters[self::FORMAT_XML]['class'] = CustomXmlResponseFormatter::className();
        return $formatters;
    }
}