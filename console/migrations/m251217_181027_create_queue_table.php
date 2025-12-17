<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m251217_181027_create_queue_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%queue}}', [
            'id' => $this->bigPrimaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'ttr' => $this->integer()->notNull(),
            'delay' => $this->integer()->notNull(),
            'priority' => $this->integer()->notNull()->defaultValue(1024),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'attempt' => $this->smallInteger()->notNull()->defaultValue(0),
            'reserved_at' => $this->integer()->defaultValue(null),
            'pushed_at' => $this->integer()->notNull(),
            'done_at' => $this->integer()->defaultValue(null),
        ]);

        $this->createIndex('idx-queue-channel', '{{%queue}}', 'channel');
    }

    public function safeDown()
    {
        $this->dropTable('{{%queue}}');
    }
}
