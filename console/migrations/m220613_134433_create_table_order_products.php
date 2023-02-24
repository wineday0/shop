<?php

use yii\db\Migration;

/**
 * Class m220613_134433_create_table_order_products
 */
class m220613_134433_create_table_order_products extends Migration
{
    public $tableName = 'order_products';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id_order' => $this->integer(),
            'id_product' => $this->integer(),
            'quantity' => $this->integer(),
        ]);
        $this->addForeignKey(
            'fk_id_orders',
            $this->tableName,
            'id_order',
            'orders',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_id_products',
            $this->tableName,
            'id_product',
            'products',
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
