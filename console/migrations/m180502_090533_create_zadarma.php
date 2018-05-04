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
            'id'            => $this->primaryKey(),
            'type'          => $this->string(10),
            'call_start'    => $this->integer(),
            'answer_time'   => $this->integer(),
            'call_end'      => $this->integer(),
            'pbx_call_id'   => $this->string(50),
            'internal'      => $this->string(50),
            'destination'   => $this->string(50),
            'disposition'   => $this->string(50),
            'status_code'   => $this->integer(),
            'is_recorded'   => $this->boolean(),
            'call_id_with_rec' => $this->string(150),
            'duration'      => $this->integer(),
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
