<?php

/* @var $this View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\components\helpers\CartHelper;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\web\View;

AppAsset::register($this);
?>
<?php
$this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php
        $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php
        $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100">
    <?php
    $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        $menuItems = [
            [
                'label' => 'Shop',
                'url' => ['/shop'],
                'active' => Yii::$app->controller->id == 'shop' && Yii::$app->controller->action->id != 'cart'
            ],
            [
                'label' => 'Orders',
                'url' => ['/orders'],
                'active' => Yii::$app->controller->id == 'orders',
                'visible' => !Yii::$app->user->isGuest,
            ],
            [
                'label' => CartHelper::getCartMenuItem(),
                'url' => ['/shop/cart'],
                'visible' => !Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Account',
                'url' => ['/account'],
                'active' => Yii::$app->controller->action->id == 'account',
                'visible' => !Yii::$app->user->isGuest,
            ],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto'],
            'items' => $menuItems,
            'encodeLabels' => false
        ]);
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        </div>
    </footer>

    <?php
    $this->endBody() ?>
    </body>
    </html>
<?php
$this->endPage();
