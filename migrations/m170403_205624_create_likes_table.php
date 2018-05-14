<?php

use yii\db\Migration;

/**
 * Handles the creation of table `likes`.
 */
class m170403_205624_create_likes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('likes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'photo_id' => $this->integer(),
            'date' => $this->timestamp(),
        ]);
        $this->createIndex('idx-likes-user_id', '{{%likes}}', 'user_id');
        $this->addForeignKey('fk-likes-user_id',
                '{{%likes}}',
                'user_id',
                '{{%users}}', 
                'id',
                'CASCADE'
                );
        $this->createIndex('idx-likes-photo_id', '{{%likes}}', 'photo_id');
         $this->addForeignKey('fk-likes-photo_id',
                '{{%likes}}',
                'photo_id',
                '{{%photos}}', 
                'id',
                'CASCADE'
                );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('likes');
    }
}
