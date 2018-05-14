<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170403_124409_create_users_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string(20)->unique(),
            'password' => $this->string(60),
            'firstname' =>  $this->string(20),
            'bio' => $this->text(),
            'avatar' => $this->string()->defaultValue('nophoto.png'),
            'verified' => $this->smallInteger()->defaultValue(0),
            'admin' => $this->smallInteger()->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
