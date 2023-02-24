<?php

namespace common\models\shop\query;

use common\models\shop\Orders;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Orders]].
 *
 * @see Orders
 */
class OrdersQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Orders[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Orders|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
