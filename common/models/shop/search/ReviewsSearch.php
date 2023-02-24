<?php

namespace common\models\shop\search;

use common\models\shop\Products;
use common\models\shop\Reviews;
use common\models\User;

/**
 * Class ReviewsSearch
 */
class ReviewsSearch extends Reviews
{
    /** @var Products */
    protected $product;

    /**
     * @param $product
     * @return void
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return Products
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return array|Reviews[]
     */
    public function searchByProduct(): array
    {
        return Reviews::find()
            ->alias('rev')
            ->select([
                'us.username',
                'userId' => 'us.id',
                'reviewId' => 'rev.id',
                'text' => 'rev.data',
                'rev.rating',
                'created_at' => "FROM_UNIXTIME(`rev`.`created_at`, '%d-%m-%Y')",
                'updated_at' => "FROM_UNIXTIME(`rev`.`updated_at`, '%d-%m-%Y')"
            ])
            ->andWhere([
                'rev.product_id' => $this->getProduct()->id,
                'rev.is_visible' => Reviews::VISIBLE_YES
            ])
            ->leftJoin(['us' => User::tableName()], 'us.id = rev.user_id')
            ->orderBy(['rev.created_at' => SORT_DESC])
            ->asArray()
            ->all();
    }
}
