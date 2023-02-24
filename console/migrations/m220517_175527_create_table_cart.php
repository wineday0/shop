<?php

use yii\db\Migration;

/**
 * Class m220517_175527_create_table_cart
 */
class m220517_175527_create_table_cart extends Migration
{
    public $tableName = 'cart';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'data' => $this->json()
        ]);

        $this->addForeignKey(
            'fk_cart_user_id_u_id',
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
