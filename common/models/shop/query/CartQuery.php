<?php

namespace common\models\shop\query;

use common\models\shop\Cart;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Cart]].
 *
 * @see Cart
 */
class CartQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Cart[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Cart|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
