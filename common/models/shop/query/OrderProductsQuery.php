<?php

namespace common\models\shop\query;

use common\models\shop\OrderProducts;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[OrderProducts]].
 *
 * @see OrderProducts
 */
class OrderProductsQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return OrderProducts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrderProducts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
