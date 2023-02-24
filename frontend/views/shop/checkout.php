<?php

/** @var $products array
 * @var $message string|null
 * @var $messageType string|null
 * @var $total int
 */

use frontend\models\checkout\PaymentForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$paymentForm = new PaymentForm();
?>

<section class="payment-form">
    <div class="container">
        <div class="block-heading">
            <h2>Payment</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quam urna, dignissim nec auctor in, mattis
                vitae leo.</p>
        </div>
        <?php
        $form = ActiveForm::begin([
            'id' => 'payment-form',
            'method' => 'POST',
        ]); ?>
        <div class="products">
            <h3 class="title">Checkout</h3>
            <?php
            foreach ($products as $product): ?>
                <div class="item">
                    <div class="item-row">
                        <p class="item-name"><?= $product['name'] ?></p>
                        <?php
                        if ($product['count'] > 1): ?>
                            <p class="item-name">x<?= $product['count'] ?></p>
                            <span class="price">$<?= $product['price'] ?></span>
                        <?php
                        endif; ?>
                        <span class="price">$<?= $product['sum'] ?></span>
                    </div>
                    <p class="item-description"><?= $product['description'] ?></p>
                </div>
            <?php
            endforeach; ?>
            <div class="total">Total<span class="price">$<?= $total ?></span></div>
        </div>
        <div class="card-details">
            <?php
            if ($message) {
                echo Html::tag('div', $message, [
                    'class' => "alert alert-$messageType",
                    'role' => 'alert'
                ]);
            }
            ?>
            <h3 class="title">Personal Info</h3>
            <div class="row">
                <div class="form-group col-sm-5">
                    <?= $form->field($paymentForm, 'name')
                        ->textInput([
                            'class' => 'form-control',
                            'aria-label' => 'Name',
                            'aria-describedby' => 'basic-addon1',
                            'placeholder' => 'eg Lorem'
                        ])
                        ->label('Name') ?>
                </div>
                <div class="form-group col-sm-6">
                    <?= $form->field($paymentForm, 'email')
                        ->textInput([
                            'class' => 'form-control',
                            'aria-label' => 'Email',
                            'aria-describedby' => 'basic-addon1',
                            'placeholder' => 'eg lorem@ipsum.su'
                        ])
                        ->label('Email') ?>
                </div>
                <div class="form-group col-sm-7">
                    <?= $form->field($paymentForm, 'address')
                        ->textInput([
                            'class' => 'form-control',
                            'aria-label' => 'Shipping address',
                            'aria-describedby' => 'basic-addon1',
                            'placeholder' => 'eg Lorem ipsum 21'
                        ])
                        ->label('Shipping address') ?>
                </div>
            </div>

            <h3 class="title">Credit Card Details</h3>
            <div class="row">
                <div class="form-group col-sm-7">
                    <?= $form->field(
                        $paymentForm,
                        'cardHolder',
                    )->textInput([
                        'class' => 'form-control',
                        'aria-label' => 'Card Holder',
                        'aria-describedby' => 'basic-addon1',
                        'placeholder' => 'Card Holder'
                    ])->label('Card Holder') ?>
                </div>
                <div class="form-group col-sm-5">
                    <?= $form->field(
                        $paymentForm,
                        'expirationDate'
                    )->textInput([
                        'class' => 'form-control',
                        'placeholder' => 'MM/YY',
                        'aria-label' => 'MM/YY',
                        'aria-describedby' => 'basic-addon1',
                    ])->label('Expiration Date') ?>
                </div>
                <div class="form-group col-sm-8">
                    <?= $form->field(
                        $paymentForm,
                        'cardNumber'
                    )->textInput([
                        'class' => 'form-control',
                        'placeholder' => 'Card Number',
                        'aria-label' => 'Card Holder',
                        'aria-describedby' => 'basic-addon1',
                    ])->label('Card Number') ?>
                </div>
                <div class="form-group col-usersm-4">
                    <?= $form->field(
                        $paymentForm,
                        'cvc'
                    )->textInput([
                        'class' => 'form-control',
                        'placeholder' => 'CVC',
                        'aria-label' => 'Card Holder',
                        'aria-describedby' => 'basic-addon1',
                    ])->label('CVC') ?>
                </div>
                <div class="form-group d-grid gap-2">
                    <?= Html::submitButton('Proceed', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
            </div>
        </div>
        <?php
        ActiveForm::end(); ?>
    </div>
</section>