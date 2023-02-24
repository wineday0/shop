<?php

namespace common\models\shop\query;

use common\models\shop\Products;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Products]].
 *
 * @see Products
 */
class ProductsQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Products[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Products|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
