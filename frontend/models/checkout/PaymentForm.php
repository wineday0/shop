<?php

namespace frontend\models\checkout;

use common\models\shop\Cart;
use common\models\shop\OrderProducts;
use common\models\shop\Orders;
use common\models\shop\search\OrdersSearch;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\db\StaleObjectException;

/**
 * Class PaymentForm
 */
class PaymentForm extends Model
{
    /** @var string|null */
    public ?string $cardHolder = null;

    /** @var int|null */
    public ?int $cardNumber = null;

    /** @var string|null */
    public ?string $expirationDate = null;

    /** @var int|null */
    public ?int $cvc = null;

    /** @var string|null */
    public ?string $address = null;

    /** @var string|null */
    public ?string $name = null;

    /** @var string|null */
    public ?string $email = null;

    /** @var User */
    protected $user;

    /**
     * @return array[]
     */
    public function rules()
    {
        return [
            [['cardHolder', 'cardNumber', 'expirationDate', 'cvc'], 'required'],
            [['cardHolder', 'expirationDate', 'address', 'name'], 'string'],
            [['cvc', 'cardNumber'], 'integer'],
            [['email'], 'email']
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        return $this->createPayment();
    }

    /**
     * @return false|int
     * @throws StaleObjectException
     * @throws Exception
     */
    public function createPayment()
    {
        $cartItems = Cart::findOne(['user_id' => $this->getUser()->id]);
        if (empty($cartItems)) {
            return false;
        }
        $batchItems = [];
        $order = $this->createOrder();
        if ($order) {
            foreach ($cartItems->data as $productsList) {
                $batchItems[] = [
                    $order->id,
                    $productsList['id'],
                    $productsList['count']
                ];
            }
            if (!empty($batchItems)) {
                $result = Yii::$app->db->createCommand()
                    ->batchInsert(
                        OrderProducts::tableName(),
                        ['id_order', 'id_product', 'quantity'],
                        $batchItems
                    )
                    ->execute();

                if ($result && $this->updateOrder($order)) {
                    return Cart::deleteAll(['user_id' => $this->getUser()->id]);
                }
            }
        }

        return false;
    }

    /**
     * @return Orders|null
     */
    public function createOrder(): ?Orders
    {
        $order = new Orders();
        $order->user_id = $this->getUser()->id;
        $order->status = Orders::STATUS_PENDING;
        $order->billing_address = $this->address;
        $order->created_at = time();
        if (!$order->save()) {
            return null;
        }
        return $order;
    }

    /**
     * @param Orders $order
     * @return false|int
     * @throws StaleObjectException
     */
    public function updateOrder(Orders $order)
    {
        $order->total_sum = OrdersSearch::getTotalOrderSum($order);
        $order->status = Orders::STATUS_COMPLETED;
        $order->updated_at = time();
        return $order->update();
    }

    /**
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}