<?php

use yii\db\Migration;

/**
 * Class m180529_142849_append_user
 */
class m180529_142849_append_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'worktime_start', $this->time());
        $this->addColumn('{{%user}}', 'worktime_end', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180529_142849_append_user cannot be reverted.\n";

        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180529_142849_append_user cannot be reverted.\n";

        return false;
    }
    */
}
