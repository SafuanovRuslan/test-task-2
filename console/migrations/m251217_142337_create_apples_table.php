<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apples}}`.
 */
class m251217_142337_create_apples_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%apples}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string()->notNull(),
            'status' => $this->integer()->notNull(),
            'eaten' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'fell_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%apples}}');
    }
}
