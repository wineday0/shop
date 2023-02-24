<?php

use yii\db\Migration;

/**
 * Class m220613_131942_create_table_orders
 */
class m220613_131942_create_table_orders extends Migration
{
    public $tableName = 'orders';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName, [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer(),
                'status' => $this->smallInteger()->unsigned(),
                'billing_address' => $this->text(),
                'total_sum' => $this->integer(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ]
        );

        $this->addForeignKey(
            'fk_orders_user_id_u_id',
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
