<?php

use common\models\shop\Category;
use common\models\shop\Products;
use common\widgets\SearchForm;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var $model Products */
?>

<ul class="nav nav-pills p-b">
    <div class="col">
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownCategory"
           data-bs-toggle="dropdown" aria-expanded="false">
            Category
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownCategory">
            <?php
            echo Html::a(
                'All',
                Url::current(['category' => null]),
                ['class' => 'dropdown-item']
            );
            foreach (Category::getCategories() as $category): ?>
                <?= Html::a(
                    $category['name'],
                    Url::current(['category' => $category['id']]),
                    ['class' => 'dropdown-item']
                ) ?>
            <?php
            endforeach; ?>
        </div>
        <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownCategory"
           data-bs-toggle="dropdown" aria-expanded="false">
            Stock
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownCategory">
            <?= Html::a(
                'All',
                Url::current(['stock' => null]),
                ['class' => 'dropdown-item']
            ); ?>
            <?= Html::a(
                'In stock',
                Url::current(['stock' => Products::IN_STOCK_YES]),
                ['class' => 'dropdown-item']
            ); ?>
            <?= Html::a(
                'Out of stock',
                Url::current(['stock' => Products::IN_STOCK_NO]),
                ['class' => 'dropdown-item']
            ); ?>
        </div>
    </div>
    <?= SearchForm::widget(['model' => $model]) ?>
</ul>