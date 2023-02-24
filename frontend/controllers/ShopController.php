<?php

namespace frontend\controllers;

use common\models\shop\Products;
use common\models\shop\search\CartSearch;
use common\models\shop\search\ProductsSearch;
use common\models\shop\search\ReviewsSearch;
use Exception;
use frontend\models\cart\AddToCartForm;
use frontend\models\cart\RemoveFromCartForm;
use frontend\models\checkout\PaymentForm;
use Yii;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * Shop Controller
 */
class ShopController extends BaseController
{
    public const CURRENCY_GENERAL = 'USD';
    public const CURRENCY_SYMBOL_GENERAL = '$';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['cart', 'append', 'checkout', 'remove'],
                'rules' => [
                    [
                        'actions' => ['cart', 'append', 'checkout', 'remove'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search();

        return $this->render('index', [
            'listDataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * @return string
     */
    public function actionView(): string
    {
        $id = Yii::$app->request->get('id');
        $product = Products::findOne(['id' => $id]);
        $reviews = [];

        if (!empty($product)) {
            $reviewSearch = new ReviewsSearch();
            $reviewSearch->setProduct($product);
            $reviews = $reviewSearch->searchByProduct();
        }

        return $this->render('product', [
            'product' => $product,
            'reviews' => $reviews,
        ]);
    }

    /**
     * @return string
     * @throws Exception
     */
    public function actionCart(): string
    {
        $searchModel = new CartSearch();
        $searchModel->setUser(Yii::$app->user);
        $products = $searchModel->search();

        return $this->render('cart', [
            'products' => $products
        ]);
    }

    /**
     * @return array
     * @throws StaleObjectException
     */
    public function actionAppend(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        $cartForm = new AddToCartForm();
        $cartForm->load($data, '');
        if (!$cartForm->save()) {
            Yii::$app->response->statusCode = 500;
            Yii::$app->session->setFlash('error', static::CODE_ERROR);
            return static::getErrorResponse();
        }
        Yii::$app->session->setFlash('success', static::CODE_SUCCESS);
        return static::getSuccessResponse();
    }

    /**
     * @return string
     * @throws Exception
     */
    public function actionCheckout(): string
    {
        $search = new CartSearch();
        $search->setUser(Yii::$app->user);
        $products = $search->search();
        $message = $messageType = null;

        if (Yii::$app->request->post()) {
            $res = $this->processing();
            $messageType = $res ? static::CODE_SUCCESS : 'danger';
            $message = Yii::$app->session->getFlash("payment-{$messageType}");
        }

        return $this->render('checkout', [
            'products' => $products,
            'message' => $message,
            'messageType' => $messageType,
            'total' => CartSearch::getCurtSum()
        ]);
    }

    /**
     * @return string[]
     * @throws StaleObjectException
     */
    public function actionRemove(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        $cartForm = new RemoveFromCartForm();
        $cartForm->load($data, '');
        if (!$cartForm->save()) {
            Yii::$app->response->statusCode = 500;
            return static::getErrorResponse();
        }
        return static::getSuccessResponse();
    }

    /**
     * @return bool
     */
    public function processing(): bool
    {
        $data = Yii::$app->request->post();

        $paymentForm = new PaymentForm();
        $paymentForm->setUser(Yii::$app->user->identity);
        $paymentForm->load($data);
        if (!$paymentForm->save()) {
            Yii::$app->session->setFlash('payment-danger', 'Internal error. Try again later.');
            return false;
        }
        Yii::$app->session->setFlash('payment-success', 'Payment success!');
        return true;
    }
}
