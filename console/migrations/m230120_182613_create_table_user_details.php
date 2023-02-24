<?php

use yii\db\Migration;

/**
 * Class m230120_182613_create_table_user_details
 */
class m230120_182613_create_table_user_details extends Migration
{
    public $tableName = 'user_details';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'first_name' => $this->text(),
            'last_name' => $this->text(),
            'address' => $this->text(),
            'phone' => $this->text(),
            'updated_at' => $this->integer(),
            
        ]);
        $this->addForeignKey(
            'fk_ud_user_id_u_id',
            $this->tableName,
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
