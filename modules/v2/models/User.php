<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {
    /**
     * @return array
     */
    public function rules() {
        return [
            [['name', 'password'], 'required'],
            ['email', 'email'],
            [['name', 'password', 'photo', 'gender', 'language', 'homepage', 'color', 'last_date', 'reg_date'], 'string'],
            ['is_banned', 'boolean'],
        ];
    }

    /**
     * @return array
     */
    public function fields() {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }

    /**
     * @param int $id
     * @return User
     */
    public static function findIdentity($id) {
        return self::findOne([
            'id' => $id,
        ]);
    }

    /**
     * @param string $token
     * @param string $type
     * @return null
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getAuthKey() {
        return null;
    }

    /**
     * @return bool
     */
    public function validateAuthKey($authKey) {
        return false;
    }
}