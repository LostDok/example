<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_card}}`.
 */
class m201122_052306_create_client_card_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_card}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'number' => $this->string(),
            'cvc' => $this->string(),
        ]);
        $this->addForeignKey('fk-client_card-client_id', '{{%client_card}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_card}}');
    }
}
