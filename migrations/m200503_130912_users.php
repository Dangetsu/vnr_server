<?php

use yii\db\Migration;

/**
 * Class m200503_130912_users
 */
class m200503_130912_users extends Migration {

    const USER_TABLE_NAME = 'user';

    public function safeUp() {
        $this->createTable(self::USER_TABLE_NAME, [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(100)->notNull(),
            'email'         => $this->string()->notNull(),
            'password'      => $this->string()->notNull(),
            'language'      => $this->string(10)->notNull(),
            'gender'        => $this->string(10)->null(),
            'homepage'      => $this->string()->null(),
            'photo'         => $this->string()->null(),
            'color'         => $this->string(10)->null(),
            'term_level'    => $this->integer(1)->defaultValue(0)->notNull(),
            'comment_level' => $this->integer(1)->defaultValue(0)->notNull(),
            'reg_date'      => $this->dateTime()->notNull(),
            'last_date'     => $this->dateTime()->notNull(),
            'is_banned'     => $this->boolean()->defaultValue(false)->notNull(),
        ]);
    }

    public function safeDown() {
        $this->dropTable(self::USER_TABLE_NAME);
    }
}
