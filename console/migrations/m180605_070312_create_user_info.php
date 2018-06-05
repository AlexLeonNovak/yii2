<?php

use yii\db\Migration;

/**
 * Class m180605_070312_create_user_info
 */
class m180605_070312_create_user_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_info}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer()->notNull(),
            'type' => $this->string(20)->notNull(),
            'value' => $this->text()->notNull(),
        ]);
        $this->createIndex('idx-users_info-id_user', '{{%users_info}}', 'id_user');
        $this->addForeignKey('fk-users_info-id_user',
                '{{%users_info}}',
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
        $this->dropForeignKey('fk-users_info-id_user', '{{%users_info}}');
        $this->dropTable('{{%users_info}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180605_070312_create_user_info cannot be reverted.\n";

        return false;
    }
    */
}
