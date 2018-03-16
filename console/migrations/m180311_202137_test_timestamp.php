<?php

use yii\db\Migration;

/**
 * Class m180311_202137_test_timestamp
 */
class m180311_202137_test_timestamp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('test_timestamp', 'id_test', 'id_theme_test');
        $this->addCommentOnColumn('test_timestamp', 'id_theme_test', 'ID Theme or ID Test');
        $this->addColumn('test_timestamp', 'for', 'BOOLEAN AFTER id');
        $this->addCommentOnColumn('test_timestamp', 'for', '0-test 1-theme');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('test_timestamp');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180311_202137_test_timestamp cannot be reverted.\n";

        return false;
    }
    */
}
