<?php

namespace common\models\shop;

use common\models\shop\query\OrderProductsQuery;
use common\models\shop\query\OrdersQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_products".
 *
 * @property int|null $id_order
 * @property int|null $id_product
 * @property int|null $quantity
 *
 * @property Orders $order
 */
class OrderProducts extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_products';
    }

    public static function primaryKey()
    {
        return ['id_order'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_order', 'id_product', 'quantity'], 'integer'],
            [
                ['id_order'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Orders::class,
                'targetAttribute' => ['id_order' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_order' => 'Id Order',
            'id_product' => 'Id Product',
            'quantity' => 'Quantity',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return ActiveQuery|OrdersQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'id_order']);
    }

    /**
     * {@inheritdoc}
     * @return OrderProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderProductsQuery(get_called_class());
    }
}
