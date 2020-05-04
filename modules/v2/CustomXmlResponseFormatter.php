<?php

namespace app\modules\v2;

use yii;

class CustomXmlResponseFormatter extends yii\web\XmlResponseFormatter {

    /** @var string */
    public $rootTag = 'grimoire';

    /**
     * @param \DOMElement $element
     * @param mixed $data
     */
    protected function buildXml($element, $data) {
        if (is_array($data)) {
            $attributes = array_key_exists('@attributes', $data) ? $data['@attributes'] : [];
            foreach ($attributes as $key => $value) {
                $element->setAttribute($key, $value);
            }
            unset($data['@attributes']);
        }
        parent::buildXml($element, $data);
    }
}