<?php

namespace frontend\components\helpers;

use common\models\shop\Cart;
use Exception;
use Yii;
use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;

/**
 * Class CartHelper
 */
class CartHelper
{
    public const CART_COUNTER_EMPTY = 0;

    /**
     * @param int $price
     * @param int $count
     * @return float|int
     */
    public static function getProductsSum(int $price, int $count)
    {
        return $price * $count;
    }

    /**
     * @return string
     * @throws Exception
     */
    public static function getCartMenuItem(): string
    {
        return '🛒' . Html::tag(
                'span',
                CartHelper::getUserItemCounter(Yii::$app->user->id),
                ['class' => 'badge rounded-pill bg-info']
            );
    }

    /**
     * @param int|null $userId
     * @return int
     * @throws Exception
     */
    public static function getUserItemCounter(?int $userId): int
    {
        if (empty($userId)) {
            return self::CART_COUNTER_EMPTY;
        }
        $products = Cart::findOne([
            'user_id' => $userId
        ]);
        $counter = self::CART_COUNTER_EMPTY;

        if (!empty($products)) {
            $products = CartHelper::getCartData($products->data);

            foreach ($products as $product) {
                $counter += ArrayHelper::getValue($product, 'count', self::CART_COUNTER_EMPTY);
            }
        }

        return $counter;
    }

    /**
     * @param array|null $data
     * @return array
     */
    public static function getCartData(?array $data): array
    {
        $result = [];
        if (empty($data)) {
            return $result;
        }
        foreach ($data as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }
}
