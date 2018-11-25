<?php
/**
 * @author Vladislav Alatorcev(Dangetsu) <clannad.business@gmail.com>
 */

namespace app\modules\v2\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {

    public function rules() {
        return [
            [['name', 'password'], 'required'],
            ['email', 'email'],
            [['name', 'password', 'photo', 'gender', 'language', 'homepage', 'color'], 'string'],
            ['is_banned', 'boolean'],
            [['last_date', 'reg_date'], 'date', 'format' => 'Y-m-d H:i:s'],
        ];
    }

    public function fields() {
        $fields = parent::fields();
        unset($fields['password']);
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return self::findOne([
            'id' => $id,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return false;
    }
}