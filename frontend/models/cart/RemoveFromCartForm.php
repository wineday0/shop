<?php

namespace frontend\models\cart;

use common\models\shop\Cart;
use Yii;
use yii\base\Model;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;

/**
 * Class RemoveFromCartForm
 */
class RemoveFromCartForm extends Model
{
    public $productId;
    public $userId;

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
    public function formName(): string
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
        $currentCart = Cart::findOne(['user_id' => $this->userId]);
        if (!empty($currentCart) && !empty($currentCart->data)) {
            $rawData = $currentCart->data;

            foreach ($rawData as $index => &$product) {
                if ($this->productId == ArrayHelper::getValue($product, 'id')) {
                    $product['count']--;
                    if ($product['count'] < 1) {
                        if (count($rawData) == 1) {
                            $currentCart->delete();
                            return true;
                        } else {
                            unset($rawData[$index]);
                        }
                    }
                }
                $currentCart->data = $rawData;
                if ($currentCart->update()) {
                    return true;
                }
            }
        }
        return false;
    }
}