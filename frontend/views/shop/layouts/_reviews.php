<?php

/**
 * @var string $username
 * @var int $userId
 * @var int $reviewId
 * @var string $date
 * @var string $text
 * @var int $rating
 */

use frontend\components\helpers\ProductItemHelper;
use frontend\models\review\ChangeReviewForm;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Modal;

?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <p class="text-sm-center"><?= $username ?></p>
                <p class="text-sm-center"><?= ProductItemHelper::getRatingStars($rating) ?></p>
            </div>
            <div class="col-md-8">
                <div class="clearfix"></div>
                <p><?= $text ?></p>
            </div>
            <div class="col-md-2 text-sm-center">
                <p class="text-secondary"><?= $date ?></p>
                <?php
                if (Yii::$app->getUser()->getId() === $userId): ?>
                    <div class="btn-group" role="group">
                        <?php
                        Modal::begin([
                            'title' => 'Edit review',
                            'toggleButton' => [
                                'label' => '✏️',
                                'class' => 'btn btn-outline-light btn-sm'
                            ],
                        ]);

                        $reviewForm = new ChangeReviewForm();
                        $form = ActiveForm::begin([
                            'options' => ['class' => 'edit-review form-floating review-create'],
                        ]);

                        echo $form->field($reviewForm, 'text')->textarea(
                            [
                                'class' => 'form-control',
                                'maxlength' => 250,
                                'rows' => 4,
                                'value' => $text,
                            ]
                        )->label(false);
                        echo $form->field($reviewForm, 'rating')->input(
                            'range',
                            [
                                'class' => 'form-range',
                                'min' => 1,
                                'max' => 5,
                                'value' => $rating
                            ]
                        )->label('Rating (from 1 to 5)');
                        echo $form->field($reviewForm, 'reviewId')->hiddenInput([
                            'value' => $reviewId
                        ])->label(false);

                        echo Html::submitButton('Save', ['class' => 'btn btn-primary float-end']);

                        ActiveForm::end();
                        Modal::end(); ?>

                        <?= Html::button('🗑️', [
                            'class' => 'remove-review btn btn-outline-light btn-sm',
                            'data-review' => $reviewId
                        ]) ?>
                    </div>
                <?php
                endif; ?>
            </div>
        </div>
    </div>
</div>
