<?php

use yii\db\Migration;

/**
 * Class m180508_070547_create_auth_tables
 */
class m180508_070547_create_auth_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%auth_modules}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
        ]);
        $this->createIndex('idx-name', '{{%auth_modules}}', 'name');
        
        $this->createTable('{{%auth_controllers}}', [
            'id' => $this->primaryKey(),
            'id_module' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
        ]);
        $this->createIndex('idx-name', '{{%auth_controllers}}', 'name');
        $this->createIndex('idx-id_module', '{{%auth_controllers}}', 'id_module');
        $this->addForeignKey('fk-auth_controllers-id_module', 
                '{{%auth_controllers}}', 
                'id_module',
                '{{%auth_modules}}', 
                'id', 
                'CASCADE', 
                'CASCADE');
        
        $this->createTable('{{%auth_actions}}', [
            'id' => $this->primaryKey(),
            'id_controller' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'description' => $this->string(),
        ]);
        $this->createIndex('idx-name', '{{%auth_actions}}', 'name');
        $this->createIndex('idx-id_controller', '{{%auth_actions}}', 'id_controller');
        $this->addForeignKey('fk-auth_actions-id_controller', 
                '{{%auth_actions}}', 
                'id_controller',
                '{{%auth_controllers}}', 
                'id', 
                'CASCADE', 
                'CASCADE');
        
        $this->createTable('{{%auth_user_actions}}', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'ids_actions' => $this->string(),
        ]);
        $this->createIndex('idx-ids_actions', '{{%auth_user_actions}}', 'ids_actions');
        $this->addForeignKey('fk-auth_user_actions-id_user',
                '{{%auth_user_actions}}',
                'id_user',
                '{{%user}}',
                'id',
                'RESTRICT',
                'RESTRICT');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-auth_user_actions-id_user', '{{%auth_user_actions}}');
        $this->dropTable('{{%auth_user_actions}}');
        $this->dropForeignKey('fk-auth_actions-id_controller', '{{%auth_actions}}');
        $this->dropTable('{{%auth_actions}}');
        $this->dropForeignKey('fk-auth_controllers-id_module', '{{%auth_controllers}}');
        $this->dropTable('{{%auth_controllers}}');
        $this->dropTable('{{%auth_modules}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180508_070547_create_auth_tables cannot be reverted.\n";

        return false;
    }
    */
}
