<?php

use yii\db\Migration;

/**
 * Class m220517_170038_create_table_products
 */
class m220517_170038_create_table_products extends Migration
{
    public $tableName = 'products';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->string()->notNull(),
            'image' => $this->binary(),
            'category' => $this->integer(),
            'in_stock' => $this->smallInteger(),
            'price' => $this->integer(),
            'rating' => $this->integer()
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
