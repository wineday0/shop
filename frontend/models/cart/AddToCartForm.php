<?php

namespace frontend\models\cart;

use common\models\shop\Cart;
use common\models\shop\Products;
use yii\base\Model;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;

/**
 * Class AddToCartForm
 */
class AddToCartForm extends Model
{
    /** @var int */
    public $productId;

    /** @var int */
    public $userId;

    /** @var bool */
    protected bool $isAppend = false;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['productId', 'userId'], 'required'],
            [['productId', 'userId'], 'integer']
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
     * @return bool
     * @throws StaleObjectException
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $productItem = Products::findOne(['id' => $this->productId]);
        if (empty($productItem)) {
            return false;
        }

        $currentCart = Cart::findOne(['user_id' => $this->userId]);
        if (!empty($currentCart)) {
            if (!empty($currentCart->data)) {
                $rawData = $currentCart->data;
                foreach ($rawData as &$product) {
                    if ($productItem->id == ArrayHelper::getValue($product, 'id')) {
                        $product['count']++;
                        $this->isAppend = true;
                    }
                }
                if (!$this->isAppend) {
                    $rawData[] = ['id' => $productItem->id, 'count' => Cart::DEFAULT_COUNTER];
                }

                $currentCart->data = $rawData;
                if (!$currentCart->update()) {
                    return false;
                }
            }
        } else {
            $rawData = [
                ['id' => $productItem->id, 'count' => Cart::DEFAULT_COUNTER]
            ];
            $cartModel = new Cart();
            $cartModel->user_id = $this->userId;
            $cartModel->data = $rawData;

            if (!$cartModel->save()) {
                return false;
            }
        }
        return true;
    }
}
