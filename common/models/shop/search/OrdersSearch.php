<?php

namespace common\models\shop\search;

use common\models\shop\OrderProducts;
use common\models\shop\Orders;
use common\models\shop\Products;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * Class OrdersSearch
 */
class OrdersSearch extends Orders
{
    /** @var User $user */
    protected $user;

    /**
     *
     * {@inheritdoc}
     * @see \common\models\shop\Cart::getUser()
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
     * @return ActiveDataProvider
     */
    public function search()
    {
        $orders = Orders::find()
            ->select(['id', 'status', 'billing_address', 'total_sum', 'created_at', 'updated_at'])
            ->andWhere(['user_id' => $this->getUser()->getId()]);
        return new ActiveDataProvider([
            'query' => $orders
        ]);
    }

    /**
     * @param Orders $order
     * @return false|int|string|null
     */
    public static function getTotalOrderSum(Orders $order)
    {
        return OrderProducts::find()
            ->alias('op')
            ->select(['total_sum' => new Expression('sum(op.quantity * p.price)')])
            ->andWhere(['op.id_order' => $order->id])
            ->leftJoin(['p' => Products::tableName()], 'p.id = op.id_product')
            ->scalar();
    }

    /**
     * @return bool|int|string|null
     */
    public static function getUserOrdersCount()
    {
        return Orders::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->cache()
            ->count();
    }

    /**
     * @return bool|int|string|null
     */
    public static function getUserOrdersSpent()
    {
        return Orders::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->cache()
            ->sum('total_sum');
    }
}