<?php

use common\models\shop\Products;
use frontend\components\helpers\ProductItemHelper;
use frontend\models\cart\AddToCartForm;
use yii\bootstrap5\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var Products $model */

$cartForm = new AddToCartForm();
?>
<div class="card" style="width: 22rem;">
    <?= Html::img(
        'data:image/png;base64,' . base64_encode($model->image),
        [
            'class' => 'card-img-top rounded mx-auto d-block',
            'alt' => $model->name,
            'style' => ['width' => '16rem', 'height' => '11rem']
        ]
    ) ?>
    <div class="card-body">
        <div class="card-title text-center">
            <?= Html::a(Html::encode($model->name), Url::to(['shop/view/' . $model->id])) ?>
        </div>
        <div class="card-subtitle mb-2 d-flex justify-content-around align-items-center">
            <?php
            if ($model->in_stock) : ?>
                <div class="">In stock</div>
                <div class="">$<?= $model->price ?></div>
            <?php
            else : ?>
                <div class="">Out of stock</div>
            <?php
            endif ?>
        </div>
        <div class="card-text p-y-1">
            <?= HtmlPurifier::process($model->description) ?>
        </div>

        <?php
        $form = ActiveForm::begin([
            'options' => [
                'class' => 'add-product'
            ]
        ]);
        ?>
        <?= $form->field($cartForm, 'productId')->hiddenInput(['value' => $model->id])->label(false) ?>
        <?= $form->field($cartForm, 'userId')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>
        <div class="card-footer d-flex p-2 justify-content-between align-items-center">
            <div class="card-subtitle"><?= ProductItemHelper::getRatingStars($model->rating) ?></div>
            <?php
            if ($model->in_stock): ?>
                <?= Html::submitButton('Buy', ['id' => 'addToCart', 'class' => 'btn btn-primary']) ?>
            <?php
            endif ?>
        </div>
        <?php
        ActiveForm::end(); ?>
    </div>
</div>