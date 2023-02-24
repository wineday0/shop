<?php

/**
 * @var User $user
 * @var UserDetails $details
 */

use common\models\shop\search\OrdersSearch;
use common\models\User;
use common\models\UserDetails;
use frontend\models\user\ChangePasswordForm;
use frontend\models\user\EditUserForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

$this->title = 'Account';
?>
<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="my-3"><?= $details->getFullName() ?? '' ?></h5>
                    <p class="text-muted mb-1">@<?= $user->username ?></p>
                    <p class="text-muted mb-4"><?= $user->email ?></p>
                    <?php
                    if (!Yii::$app->user->isGuest) {
                        Modal::begin([
                            'toggleButton' => [
                                'label' => 'Change password',
                                'class' => 'btn btn-primary'
                            ],
                        ]);

                        $userForm = new ChangePasswordForm();
                        $form = ActiveForm::begin([
                            'options' => ['class' => 'change-password form-floating'],
                        ]);

                        echo $form->field($userForm, 'currentPassword')->input('password', [
                            'class' => 'form-control',
                        ]);
                        echo $form->field($userForm, 'newPassword')->input('password', [
                            'class' => 'form-control',
                        ]);
                        echo $form->field($userForm, 'passwordRepeat')->input('password', [
                            'class' => 'form-control',
                        ]);
                        echo $form->field($userForm, 'userId')->hiddenInput([
                            'value' => $user->id
                        ])->label(false);

                        echo Html::submitButton('Save', ['class' => 'btn btn-primary float-end']);

                        ActiveForm::end();
                        Modal::end();
                    }
                    ?>
                </div>
            </div>
            <div class="card mb-4 mb-lg-0">
                <div class="card-body p-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Orders</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-end mb-0"><?= OrdersSearch::getUserOrdersCount() ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Spent</p>
                            </div>
                            <div class="col-sm-9">
                                <p class="text-end mb-0"><?= OrdersSearch::getUserOrdersSpent() ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Full Name</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $details->getFullName() ?? '' ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $user->email ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Phone</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $details->phone ?? '' ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0">Address</p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0"><?= $details->address ?? '' ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-9">
                            <?php
                            if (!Yii::$app->user->isGuest) {
                                Modal::begin([
                                    'toggleButton' => [
                                        'label' => 'Change',
                                        'class' => 'btn btn-primary'
                                    ],
                                ]);

                                $userForm = new EditUserForm();
                                $form = ActiveForm::begin([
                                    'options' => ['class' => 'edit-user form-floating'],
                                ]);

                                echo $form->field($userForm, 'email')->input('email', [
                                    'class' => 'form-control',
                                    'placeholder' => 'lorem@ip.sum',
                                    'maxlength' => 50,
                                    'value' => $user->email,
                                ]);
                                echo $form->field($userForm, 'firstName')->textInput(
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => 'Lorem',
                                        'maxlength' => 50,
                                        'value' => $details->first_name,
                                    ]
                                );
                                echo $form->field($userForm, 'lastName')->textInput(
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => 'Ipsum',
                                        'maxlength' => 50,
                                        'value' => $details->last_name,
                                    ]
                                );
                                echo $form->field($userForm, 'phone')->input(
                                    'integer',
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => '8424242',
                                        'maxlength' => 9,
                                        'value' => $details->phone,
                                    ]
                                );
                                echo $form->field($userForm, 'address')->textInput(
                                    [
                                        'class' => 'form-control',
                                        'placeholder' => '294 Selby St. Deer Park, NY 11729 Change',
                                        'maxlength' => 50,
                                        'value' => $details->address,
                                    ]
                                );
                                echo $form->field($userForm, 'userId')->hiddenInput([
                                    'value' => $user->id
                                ])->label(false);

                                echo Html::submitButton('Save', ['class' => 'btn btn-primary float-end']);

                                ActiveForm::end();
                                Modal::end();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>