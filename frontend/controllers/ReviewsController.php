<?php

namespace frontend\controllers;

use frontend\models\review\ChangeReviewForm;
use frontend\models\review\CreateReviewForm;
use frontend\models\review\RemoveReviewForm;
use Yii;
use yii\web\Response;

/**
 * Class ReviewsController
 */
class ReviewsController extends BaseController
{
    public const CODE_SUCCESS = 'success';
    public const CODE_ERROR = 'error';

    /**
     * @return string[]
     * @throws \Throwable
     */
    public function actionCreate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new CreateReviewForm();
        $form->setUser(Yii::$app->user->getIdentity());
        $form->load(Yii::$app->request->post());
        if (!$form->save()) {
            Yii::$app->session->setFlash('error', $form->getErrors('error'));
            return static::getErrorResponse();
        } else {
            Yii::$app->session->setFlash('success', 'Thank you for a review!');
        }
        return static::getSuccessResponse();
    }

    /**
     * @return string[]
     */
    public function actionRemove()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new RemoveReviewForm();
        $form->load(Yii::$app->request->post(), '');
        if (!$form->remove()) {
            Yii::$app->session->setFlash('error', $form->getErrors('error'));
            return static::getErrorResponse();
        } else {
            Yii::$app->session->setFlash('success', 'Review has been deleted');
        }
        return static::getSuccessResponse();
    }

    /**
     * @return string[]
     */
    public function actionChange()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new ChangeReviewForm();
        $form->load(Yii::$app->request->post());
        if (!$form->change()) {
            Yii::$app->session->setFlash('error', $form->getErrors('error'));
            return static::getErrorResponse();
        } else {
            Yii::$app->session->setFlash('success', 'Review has been changed');
        }
        return static::getSuccessResponse();
    }
}
