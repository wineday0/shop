<?php

/**
 * @var yii\web\View $this
 * @var array $products
 */

use common\models\shop\search\CartSearch;
use frontend\components\helpers\CartHelper;
use yii\bootstrap5\Html;

$this->title = 'Cart';
?>
<?php
if (!empty($products)): ?>
    <table class="table table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Count</th>
            <th scope="col"></th>
            <th scope="col">Price</th>
            <th scope="col">Sum</th>
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
                <td>
                    <?= Html::button(
                        '-',
                        [
                            'class' => 'cart-remove btn btn-danger btn-sm',
                            'data-product' => $product['id'],
                            'data-user' => Yii::$app->user->id
                        ]
                    ) ?>
                    <?= Html::button(
                        '+',
                        [
                            'class' => 'cart-add btn btn-primary btn-sm',
                            'data-product' => $product['id'],
                            'data-user' => Yii::$app->user->id
                        ]
                    ) ?>
                </td>
                <td>$<?= $product['price'] ?></td>
                <td>$<?= $product['sum'] ?></td>
            </tr>
        <?php
        endforeach ?>
        <tr class="table-info">
            <td>Sum:</td>
            <td></td>
            <td></td>
            <td><?= CartHelper::getUserItemCounter(Yii::$app->user->id) ?></td>
            <td></td>
            <td></td>
            <td>$<?= CartSearch::getCurtSum() ?></td>
        </tr>
        </tbody>
    </table>
    <div>
        <div><?= Html::a('Go to checkout', 'checkout', ['class' => 'btn btn-success']) ?></div>
    </div>
<?php
else: ?>
    <h5>Empty cart</h5>
<?php
endif; ?>