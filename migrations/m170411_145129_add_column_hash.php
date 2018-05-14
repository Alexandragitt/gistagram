<?php

use yii\db\Migration;

class m170411_145129_add_column_hash extends Migration
{
    public function up()
    {
        $this->addColumn('users', 'hash', $this->string(70));
    }

    public function down()
    {
        $this->dropColumn('users', 'hash');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
