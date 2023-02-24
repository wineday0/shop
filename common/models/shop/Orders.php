<?php

namespace common\models\shop;

use common\models\shop\query\OrderProductsQuery;
use common\models\shop\query\OrdersQuery;
use frontend\controllers\ShopController;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $status
 * @property string|null $billing_address
 * @property int|null $total_sum
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property OrderProducts[] $orderProducts
 */
class Orders extends ActiveRecord
{
    public const STATUS_PENDING = 0;
    public const STATUS_SUCCESS = 1;
    public const STATUS_COMPLETED = 2;
    public const STATUS_ERROR = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'total_sum', 'created_at', 'updated_at'], 'integer'],
            [['billing_address'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'billing_address' => 'Billing Address',
            'total_sum' => 'Total Sum',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[OrderProducts]].
     *
     * @return ActiveQuery|OrderProductsQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProducts::class, ['id_order' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            static::STATUS_PENDING => 'Pending',
            static::STATUS_SUCCESS => 'Success',
            static::STATUS_COMPLETED => 'Completed',
            static::STATUS_ERROR => 'Error'
        ];
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return is_null($this->total_sum)
            ? 0
            : ShopController::CURRENCY_SYMBOL_GENERAL . $this->total_sum;
    }
}
