<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comments`.
 */
class m170403_155001_create_comments_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'photo_id' => $this->integer(),
            'comment' => $this->text(),
            'date' => $this->timestamp(),
        ]);
        
        $this->createIndex('idx-comments-user_id', '{{%comments}}', 'user_id');
        $this->addForeignKey('fk-comments-user_id',
                '{{%comments}}',
                'user_id',
                '{{%users}}', 
                'id',
                'CASCADE'
                );
        $this->createIndex('idx-comments-photo_id', '{{%comments}}', 'photo_id');
        $this->addForeignKey('fk-comments-photo_id',
                '{{%comments}}',
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
        $this->dropTable('comments');
    }
}
