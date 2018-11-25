<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord {

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }
}