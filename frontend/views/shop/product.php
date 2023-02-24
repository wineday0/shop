<?php

/**
 * @var $product Products
 * @var $reviews array
 */

use common\models\shop\Products;
use frontend\components\helpers\ProductItemHelper;
use frontend\models\cart\AddToCartForm;
use frontend\models\review\CreateReviewForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

$cartForm = new AddToCartForm();
?>
<div class="container">
    <div class="col-lg-12 border p-3 main-section bg-white">
        <div class="row hedding m-0 pl-3 pt-0 pb-3">
            <h6 class="col-sm-10 col-md-10"><?= $product->name ?></h6>
            <div class="col-sm-2 col-md-2">
                <?= ProductItemHelper::getRatingStars($product->rating) ?>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-lg-4 left-side-product-box pb-3">
                <?= Html::img('data:image/png;base64,' . base64_encode($product->image), [
                    'class' => 'border p-1',
                    'alt' => $product->name,
                    'style' => [
                        'width' => '260px',
                        'height' => '180px'
                    ]
                ]) ?>
            </div>
            <div class="col-lg-8">
                <div class="right-side-pro-detail border p-3 m-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <h6><?= $product->getCategoryName($product->category)->name ?></h6>
                            <p class="m-0 p-0"><?= $product->name ?></p>
                            <br>
                        </div>
                        <div class="col-lg-12">
                            <p class="m-0 p-0">$<?= $product->price ?></p>
                            <hr class="p-0 m-0">
                        </div>
                        <div class="col-lg-12 pt-2">
                            <h6>Product Detail</h6>
                            <span><?= $product->description ?></span>
                            <hr class="m-0 pt-2 mt-2">
                        </div>
                        <div class="col-lg-12">
                            <p class="tag-section">
                                <strong>In stock: <?= $product->in_stock ? 'Yes' : 'No' ?></strong>
                            </p>
                        </div>

                        <div class="col-lg-12 mt-3">
                            <?php
                            $form = ActiveForm::begin([
                                'options' => ['class' => 'add-product']
                            ]);
                            ?>
                            <?= $form->field($cartForm, 'productId')->hiddenInput(['value' => $product->id])->label(
                                false
                            ) ?>
                            <?= $form->field($cartForm, 'userId')->hiddenInput(['value' => Yii::$app->user->id])->label(
                                false
                            ) ?>
                            <?php
                            if ($product->in_stock): ?>
                                <div class="row">
                                    <div class="col-lg-6 pb-2">
                                        <?= Html::submitButton('Buy', ['class' => 'btn btn-danger w-100']) ?>
                                    </div>
                                    <div class="col-lg-6">
                                        <?= Html::a('Shop now', '/shop/checkout', ['class' => 'btn btn-success w-100']
                                        ) ?>
                                    </div>
                                </div>
                            <?php
                            endif; ?>
                            <?php
                            ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fs-5">Reviews
            <?php
            if (!Yii::$app->user->isGuest) {
                Modal::begin([
                    'title' => 'Create review',
                    'toggleButton' => [
                        'label' => '+',
                        'class' => 'badge btn btn-primary btn-circle'
                    ],
                ]);

                $reviewForm = new CreateReviewForm();
                $form = ActiveForm::begin([
                    'options' => ['class' => 'add-review form-floating review-create'],
                ]);

                echo $form->field($reviewForm, 'text')->textarea(
                    [
                        'class' => 'form-control',
                        'placeholder' => 'Leave a review here',
                        'maxlength' => 250,
                        'rows' => 4,
                    ]
                )->label(false);
                echo $form->field($reviewForm, 'rating')->input(
                    'range',
                    [
                        'class' => 'form-range',
                        'min' => 1,
                        'max' => 5,
                    ]
                )->label('Rating (from 1 to 5)');
                echo $form->field($reviewForm, 'productId')->hiddenInput([
                    'value' => $product->id
                ])->label(false);

                echo Html::submitButton('Save', ['class' => 'btn btn-primary float-end']);

                ActiveForm::end();
                Modal::end();
            }
            ?>
        </div>
        <br>
        <?php
        if (!empty($reviews)) {
            foreach ($reviews as $review) {
                echo $this->render(
                    'layouts/_reviews',
                    [
                        'userId' => $review['userId'],
                        'reviewId' => $review['reviewId'],
                        'username' => $review['username'],
                        'date' => $review['created_at'],
                        'text' => $review['text'],
                        'rating' => $review['rating']
                    ]
                );
            }
        } else {
            echo 'No reviews for the product, be the first';
        }
        ?>
    </div>
</div>
