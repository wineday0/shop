<?php

namespace common\models\shop;

use common\models\shop\query\CategoryQuery;
use common\models\shop\query\ProductsQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $name
 * @property int|null $category
 * @property resource|null $image
 * @property string $description
 * @property int $in_stock
 * @property int $price
 * @property int $rating
 *
 * @property Category $category0
 */
class Products extends ActiveRecord
{
    public const IN_STOCK_YES = 1;

    public const IN_STOCK_NO = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name', 'image', 'description', 'categoryName'], 'string'],
            [['category', 'in_stock', 'price', 'rating'], 'integer'],
            [
                ['category'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::class,
                'targetAttribute' => ['category' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'category' => 'Category',
            'image' => 'Image',
            'description' => 'Description',
            'price' => 'Price',
            'rating' => 'Rating',
            'in_stock' => 'In Stock',
        ];
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return ActiveQuery|CategoryQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }

    /**
     * @param int $categoryId
     * @return array|Category|null
     */
    public function getCategoryName(int $categoryId)
    {
        return Category::find()
            ->select(['name'])
            ->where(['id' => $categoryId])
            ->limit(1)->one();
    }

    /**
     * {@inheritdoc}
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}
