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
            'event' => $this->string(20),
            'duration' => $this->integer(),
            'caller_id' => $this->integer(),
            'called_did' => $this->integer(),
            'call_start' => $this->string(20),
            'pbx_call_id' => $this->string(50),
            'internal' => $this->integer(),
            'destination' => $this->string(20),
            'disposition' => $this->string(30),
            'status_code' => $this->integer(),
            'is_recorded' => $this->boolean(),
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
