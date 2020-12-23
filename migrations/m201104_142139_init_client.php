<?php

use yii\db\Migration;

/**
 * Class m201104_142139_init_client
 */
class m201104_142139_init_client extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email_confirm_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%client_work_line}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->insert('{{%client_work_line}}', ['name' => 'Архитектор']);
        $this->insert('{{%client_work_line}}', ['name' => 'Руководитель компании']);

        $this->createTable('{{%organization_work_line}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        $this->insert('{{%organization_work_line}}', ['name' => 'Строительная компания']);
        $this->insert('{{%organization_work_line}}', ['name' => 'Дизайн студия']);

        $this->createTable('{{%organization}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'work_line_id' => $this->integer(),
            'photo' => $this->string(),
            'owner_id' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk-organization-work_line_id', '{{%organization}}', 'work_line_id', '{{%organization_work_line}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk-organization-owner_id', '{{%organization}}', 'owner_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%client_info}}', [
            'client_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'surname' => $this->string(),
            'username' => $this->string(),
            'display_type' => $this->smallInteger()->notNull()->defaultValue(1),
            'phone' => $this->string(),
            'gender' => $this->integer(),
            'birth_date' => $this->date(),
            'work_line_id' => $this->integer(),
            'photo' => $this->string(),
            'organization_id' => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk-client_info-client_id', '{{%client_info}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-client_info-organization_id', '{{%client_info}}', 'organization_id', '{{%organization}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey('fk-client_info-work_line_id', '{{%client_info}}', 'work_line_id', '{{%client_work_line}}', 'id', 'SET NULL', 'CASCADE');

        $this->createTable('{{%client_tariff}}', [
            'client_id' => $this->integer()->notNull(),
            'tariff_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'expired_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk-client_tariff-client_id', '{{%client_tariff}}', 'client_id', '{{%client}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_tariff}}');
        $this->dropTable('{{%client_info}}');
        $this->dropTable('{{%organization}}');
        $this->dropTable('{{%organization_work_line}}');
        $this->dropTable('{{%client_work_line}}');
        $this->dropTable('{{%client}}');
    }
}
