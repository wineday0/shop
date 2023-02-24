<?php

namespace common\models\shop\search;

use common\models\shop\Cart;
use common\models\shop\Products;
use common\models\User;
use Exception;
use frontend\components\helpers\CartHelper;
use yii\helpers\ArrayHelper;

/**
 * Class CartSearch
 */
class CartSearch extends Cart
{
    /** @var int */
    private static int $cartSum = 0;

    /** @var User $user */
    protected $user;

    /**
     * @return int
     */
    public static function getCurtSum(): int
    {
        return static::$cartSum;
    }

    /**
     *
     * {@inheritdoc}
     * @see Cart::getUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     *
     * {@inheritdoc}
     * @see Cart::rules
     */
    public function rules()
    {
        return [];
    }

    /**
     *
     * {@inheritdoc}
     * @see \yii\base\Model::formName()
     */
    public function formName()
    {
        return '';
    }

    /**
     * @return array
     * @throws Exception
     */
    public function search(): array
    {
        $products = Cart::findOne([
            'user_id' => $this->user->id
        ]);

        if (empty($products)) {
            return [];
        }

        $products = CartHelper::getCartData($products->data);
        $this->prepareCartProducts($products);

        return $products;
    }

    /**
     * @param array $products
     * @throws Exception
     */
    protected function prepareCartProducts(array &$products)
    {
        foreach ($products as &$product) {
            $id = ArrayHelper::getValue($product, 'id');
            $count = ArrayHelper::getValue($product, 'count');
            $productModel = Products::findOne([
                'id' => $id
            ]);

            $sum = CartHelper::getProductsSum($productModel->price, $count);
            static::$cartSum += $sum;

            $product['image'] = $productModel->image;
            $product['name'] = $productModel->name;
            $product['price'] = $productModel->price;
            $product['sum'] = $sum;
            $product['description'] = $productModel->description;
        }
    }
}
