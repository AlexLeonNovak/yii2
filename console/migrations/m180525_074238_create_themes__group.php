<?php

use yii\db\Migration;

/**
 * Class m180525_074238_create_themes__group
 */
class m180525_074238_create_themes__group extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {      
        $new_table = '{{%test_themes__users_group}}';
        $this->createTable($new_table, [
            'id_theme' => $this->integer()->notNull(),
            'id_group' => $this->integer()->notNull(),
        ]);
        $this->createIndex('idx-id_theme', $new_table, 'id_theme');
        $this->createIndex('idx-id_group', $new_table, 'id_group');
        $this->addForeignKey('fk-test_themes__users_group-id_theme',
                $new_table,
                'id_theme',
                '{{%test_themes}}',
                'id',
                'CASCADE',
                'CASCADE');
        $this->addForeignKey('fk-test_themes__users_group-id_group',
                $new_table,
                'id_group',
                '{{%users_group}}',
                'id',
                'CASCADE',
                'CASCADE');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180525_074238_create_themes__group cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180525_074238_create_themes__group cannot be reverted.\n";

        return false;
    }
    */
}
