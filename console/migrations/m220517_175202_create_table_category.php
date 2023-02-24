<?php

use yii\db\Migration;

/**
 * Class m220517_175202_create_table_category
 */
class m220517_175202_create_table_category extends Migration
{
    public $tableName = 'category';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
