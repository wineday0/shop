<?php

/**
 * @var array $products
 * @var Orders|null $order
 * @var int $totalCount
 */

use common\models\shop\Orders;
use common\models\shop\search\OrdersSearch;
use yii\bootstrap5\Html;

$this->title = 'Order history';
?>

<?php
if (empty($products)): ?>
    <div>Empty history</div>
<?php
else: ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Count</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($products as $key => $product) : ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= Html::img(
                        'data:image/png;base64,' . base64_encode($product['image']),
                        [
                            'class' => 'rounded mx-auto',
                            'alt' => $product['name'],
                            'style' => ['width' => '100px', 'height' => '55px']
                        ]
                    ) ?></td>
                <td><?= Html::a($product['name'], ["shop/view/{$product['id']}"]) ?></td>
                <td><?= $product['count'] ?></td>
            </tr>
        <?php
        endforeach; ?>
        <tr class="table-info">
            <td>Total:</td>
            <td></td>
            <td>$<?= OrdersSearch::getTotalOrderSum($order) ?></td>
            <td><?= $totalCount ?></td>
        </tr>
        </tbody>
    </table>
<?php
endif; ?>