<?php

use yii\db\Migration;

/**
 * Handles the creation of table `photos`.
 */
class m170403_153337_create_photos_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%photos}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'photo' => $this->string(60),
            'description' => $this->string(),
            'location' => $this->string(),
            'date' => $this->timestamp(),
            'views' => $this->integer()->defaultValue(0)
                ]);
        
         $this->createIndex('idx-photos-user_id', '{{%photos}}', 'user_id');
         $this->addForeignKey(
            'fk-photos-user_id',
            '{{%photos}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%photos}}');
    }
}
