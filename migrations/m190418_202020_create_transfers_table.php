<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transfers}}`.
 */
class m190418_202020_create_transfers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transfers}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(7,2)->defaultValue(0.00),
            'to_user_id' => $this->integer()->notNull(),

        ]);

        $this->addForeignKey(
            'fk-transfers-user_id',
            'transfers',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-transfers-to_user_id',
            'transfers',
            'to_user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transfers}}');
    }
}
