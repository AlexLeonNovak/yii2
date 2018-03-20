<?php

use yii\db\Migration;

/**
 * Class m180320_070230_create_table_users_contact
 */
class m180320_070230_create_table_users_contact extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_contact}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'type' => $this->string(20)->notNull(),
            'value' => $this->string(150)->notNull(),
        ]);
        $this->createIndex('idx-users_contact-id_user', '{{%users_contact}}', 'id_user');
        $this->addForeignKey('fk-users_contact-id_user',
                '{{%users_contact}}',
                'id_user',
                '{{%user}}',
                'id',
                'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_contact}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180320_070230_create_table_users_contact cannot be reverted.\n";

        return false;
    }
    */
}
