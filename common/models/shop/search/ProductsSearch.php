<?php

namespace common\models\shop\search;

use common\models\shop\Category;
use common\models\shop\OrderProducts;
use common\models\shop\Products;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class ProductsSearch
 */
class ProductsSearch extends Products
{
    /** @var string */
    public string $searchWord = '';

    /** @var int */
    public mixed $category = null;

    /** @var int */
    public mixed $stock = null;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['searchWord'], 'string', 'min' => 1, 'max' => 250],
            [['searchWord'], 'trim'],
            [['category', 'stock'], 'integer'],
            [['category'], 'in', 'range' => ArrayHelper::getColumn(Category::getCategories(), 'id')],
            [['stock'], 'in', 'range' => [Products::IN_STOCK_NO, Products::IN_STOCK_YES]],
        ];
    }

    /**
     * @return string
     */
    public function formName()
    {
        return '';
    }

    /**
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Products::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6
            ],
            'sort' => [
                'attributes' => ['id']
            ]
        ]);

        $this->load(Yii::$app->request->get());

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->joinWith(['category']);

        if (!empty($this->searchWord)) {
            $query->andFilterWhere(['like', 'products.name', $this->searchWord]);
        }
        if (!empty($this->category)) {
            $query->andFilterWhere(['products.category' => $this->category]);
        }
        if (!is_null($this->stock)) {
            $query->andFilterWhere(['products.in_stock' => $this->stock]);
        }

        $query->orderBy(['in_stock' => SORT_DESC]);
        return $dataProvider;
    }

    /**
     * @param int $orderId
     * @return array|OrderProducts[]
     */
    public static function getProductsByOrder(int $orderId): array
    {
        return OrderProducts::find()
            ->alias('op')
            ->select(['count' => 'op.quantity', 'p.name', 'p.image', 'p.id'])
            ->andWhere(['op.id_order' => $orderId])
            ->leftJoin(['p' => Products::tableName()], 'p.id = op.id_product')
            ->asArray()
            ->all();
    }

    public function getCount()
    {
        return static::find()->count('id');
    }
}
