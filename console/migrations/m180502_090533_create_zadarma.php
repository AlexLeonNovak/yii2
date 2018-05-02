<?php

use yii\db\Migration;

/**
 * Class m180502_090533_create_zadarma
 */
class m180502_090533_create_zadarma extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%zadarma}}', [
            'id' => $this->primaryKey(),
            'caller_id' => $this->integer(),
            'called_did' => $this->integer(),
            'call_start' => $this->integer(),
            'pbx_call_id' => $this->integer(),
            'internal' => $this->integer(),
            'destination' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%zadarma}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180502_090533_create_zadarma cannot be reverted.\n";

        return false;
    }
    */
}
