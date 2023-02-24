<?php

namespace common\models\shop\query;

use common\models\shop\Reviews;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Reviews]].
 *
 * @see Reviews
 */
class ReviewsQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Reviews[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Reviews|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
