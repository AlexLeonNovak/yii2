<?php

use yii\db\Migration;

/**
 * Class m180319_085133_create_table_test_settings
 */
class m180319_085133_create_table_test_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%test_settings}}', [
            'id' => $this->primaryKey(),
            'id_group' => $this->integer()->notNull(),
            'timer' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-test_settings-id_group', 'test_settings', 'id_group');
        $this->addForeignKey('fk-test_settings-id_group',
                '{{%test_settings}}',
                'id_group',
                '{{%users_group}}',
                'id',
                'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('{{%test_settings}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_085133_create_table_test_settings cannot be reverted.\n";

        return false;
    }
    */
}
