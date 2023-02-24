<?php

use common\models\shop\Products;
use yii\db\Migration;

/**
 * Class m220524_181920_insert_products_data
 */
class m220524_181920_insert_products_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $products = [
            'Nikon D7000' => '1',
            'Canon eos r7' => '1',
            'Macbook Air M1' => '2',
            'HP OMEN i7' => '2',
            'Apple AirPods' => '3',
            'Beats Solo 3' => '3',
            'Samsung Galaxy S20' => '4',
            'iPhone 13 Pro' => '4',
            'Logitech G213' => '5',
            'HP X500' => '5'
        ];

        foreach ($products as $name => $category) {
            $this->insert(
                Products::tableName(),
                [
                    'name' => $name,
                    'category' => $category,
                    'image' => file_get_contents('/app/console/migrations/img/default-image.jpg'),
                    'description' => 'Lorem ipsum dolor sit amet',
                    'price' => rand(100, 1000),
                    'rating' => rand(1, 5),
                    'in_stock' => rand(0, 1)
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable(Products::tableName());
    }
}
