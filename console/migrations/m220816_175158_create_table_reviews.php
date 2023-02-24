<?php

use yii\db\Migration;

/**
 * Class m220816_175158_create_table_reviews
 */
class m220816_175158_create_table_reviews extends Migration
{
    public $tableName = 'reviews';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'product_id' => $this->integer(),
            'data' => $this->text(),
            'rating' => $this->integer(),
            'is_visible' => $this->smallInteger(2),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk_reviews_user_id_u_id',
            $this->tableName,
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk_reviews_product_id_p_id',
            $this->tableName,
            'product_id',
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
