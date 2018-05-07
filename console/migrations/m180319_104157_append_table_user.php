<?php

use yii\db\Migration;

/**
 * Class m180319_104157_append_table_user
 */
class m180319_104157_append_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'firstName', $this->string(50));
        $this->addColumn('{{%user}}', 'middleName', $this->string(50));
        $this->addColumn('{{%user}}', 'lastName', $this->string(50));
        $this->addColumn('{{%user}}', 'dateOfBirth', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180319_104157_append_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180319_104157_append_table_user cannot be reverted.\n";

        return false;
    }
    */
}
