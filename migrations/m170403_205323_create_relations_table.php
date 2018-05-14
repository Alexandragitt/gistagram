<?php

use yii\db\Migration;

/**
 * Handles the creation of table `relations`.
 */
class m170403_205323_create_relations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('relations', [
            'id' => $this->primaryKey(),
            'first_id' => $this->integer(),
            'second_id' => $this->integer(),
            'type' => $this->integer(),
        ]);
        $this->createIndex('idx-relations-first_id', '{{%relations}}', 'first_id');
        $this->addForeignKey('fk-relations-first_id',
                '{{%relations}}',
                'first_id',
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
        $this->dropTable('relations');
    }
}
