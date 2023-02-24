<?php

/**
 * @var $this yii\web\View
 * @var $listDataProvider ActiveDataProvider
 * @var $searchModel ProductsSearch
 */

use common\models\shop\search\ProductsSearch;
use yii\bootstrap5\LinkPager;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->title = 'Shop';
?>
<?= $this->render('layouts/_search', ['model' => $searchModel]) ?>

<div class="py-5">
    <div class="container-fluid">
        <?= ListView::widget([
            'options' => [
                'tag' => 'div',
                'class' => 'row row-cols-1 row-cols-md-2'
            ],
            'dataProvider' => $listDataProvider,
            'itemView' => 'layouts/_product_item',
            'itemOptions' => [
                'class' => 'col-md-6 mx-auto d-flex justify-content-center',
                'style' => [
                    'padding' => '.5em 0em',
                ]
            ],
            'layout' => "{items}",
        ]) ?>

        <nav aria-label="Page navigation">
            <?= LinkPager::widget([
                'pagination' => $listDataProvider->pagination,
                'class' => LinkPager::class,
                'maxButtonCount' => 4,
                'options' => ['class' => 'justify-content-center']
            ]) ?>
        </nav>
    </div>
</div>