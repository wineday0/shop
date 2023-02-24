<?php

use common\models\shop\Category;
use yii\db\Migration;

/**
 * Class m220524_175357_insert_category_data
 */
class m220524_175357_insert_category_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $names = ['Camera & Photo', 'Computers', 'Portable Audio & Video', 'Phones', 'Other'];

        foreach ($names as $name) {
            $this->insert(Category::tableName(), [
                'name' => $name
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable(Category::tableName());
    }
}
