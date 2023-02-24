<?php

/* @var array $orders */

use common\models\shop\Orders;
use yii\bootstrap5\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Orders';
?>

<?php
if (empty($orders)): ?>
    <div>Orders empty</div>
<?php
else: ?>
    <?= GridView::widget([
        'dataProvider' => $orders,
        'tableOptions' => ['class' => 'table table-hover'],
        'columns' => [
            'id',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    /** @var Orders $model */
                    return Orders::getStatuses()[$model->status];
                }
            ],
            'billing_address',
            [
                'attribute' => 'total_sum',
                'value' => function ($model) {
                    /** @var Orders */
                    return $model->getPrice();
                },
            ],
            ['attribute' => 'created_at', 'format' => ['date', 'php:d-M-Y H:i:s']],
            ['attribute' => 'updated_at', 'format' => ['date', 'php:d-M-Y H:i:s']],
            [
                'attribute' => 'products',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('↗️', Url::to(['orders/history/' . $model->id]));
                },
            ]
        ],
    ]) ?>
<?php
endif ?>