<?php

namespace frontend\controllers;

use common\models\shop\Orders;
use common\models\shop\search\OrdersSearch;
use common\models\shop\search\ProductsSearch;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class OrdersController
 */
class OrdersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
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
        $orders = new OrdersSearch();
        $orders->setUser(Yii::$app->user);
        return $this->render(
            'index',
            [
                'orders' => $orders->search()
            ]
        );
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionHistory(): string
    {
        $orderId = Yii::$app->request->get('id');
        if (empty($orderId)) {
            throw new NotFoundHttpException('Order not found');
        }
        $order = Orders::findOne(['id' => $orderId]);
        $products = ProductsSearch::getProductsByOrder($orderId);
        $totalCount = 0;
        foreach ($products as $product) {
            $totalCount += $product['count'];
        }

        return $this->render('history', [
            'products' => $products,
            'order' => $order,
            'totalCount' => $totalCount
        ]);
    }
}