<?php

use yii\db\Migration;

/**
 * Class m180329_075113_append_test_timestamp
 */
class m180329_075113_append_test_timestamp extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%test_timestamp}}', 'totaltime', $this->float());
        $this->addColumn('{{%test_timestamp}}', 'violation', $this->boolean()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180329_075113_append_test_timestamp cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180329_075113_append_test_timestamp cannot be reverted.\n";

        return false;
    }
    */
}
