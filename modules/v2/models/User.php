<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

use yii\web;

class User extends Base implements web\IdentityInterface {

    const PARAMETER_ID       = 'id';
    const PARAMETER_PASSWORD = 'password';

    /**
     * @return array
     */
    public function rules() {
        return [
            [['name', self::PARAMETER_PASSWORD, 'email'], 'required'],
            ['email', 'email'],
            [['name', 'password', 'photo', 'gender', 'language', 'homepage', 'color', 'last_date', 'reg_date'], 'string'],
            ['is_banned', 'boolean'],
        ];
    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true) {
        $response = parent::toArray($fields, $expand, $recursive);
        $response['@attributes'] = ['id' => $response[self::PARAMETER_ID]];
        unset($response[self::PARAMETER_ID], $response[self::PARAMETER_PASSWORD]);
        return $response;
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
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey) {
        return false;
    }
}