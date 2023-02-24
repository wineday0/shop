<?php

namespace common\widgets\views;

use yii\base\Model;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model Model
 * @var $paramsForm array
 * @var $paramsField array
 * @var ActiveForm $activeForm
 */

?>
<div class="form-row">
    <?php
    /** @var ActiveForm $form */
    $form = $activeForm::begin($paramsForm) ?>
    <div class="col input-group">
        <?= $form->field($model, $paramsField['attribute'], ['template' => "{input}"])->textInput(
            ['maxlength' => 255, 'class' => 'form-control rounded']
        )->input(
            $paramsField['type'],
            ['placeholder' => $paramsField['placeholder']]
        ) ?>
        <?= Html::beginTag('span') ?>
        <?= Html::input('submit', null, 'Find', ['class' => 'btn btn-outline-primary']); ?>
        <?= Html::endTag('span') ?>
    </div>
    <?php
    $activeForm::end() ?>
</div>