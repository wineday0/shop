<?php

namespace frontend\controllers;

use frontend\models\review\ChangeReviewForm;
use frontend\models\review\CreateReviewForm;
use frontend\models\review\RemoveReviewForm;
use Throwable;
use Yii;
use yii\web\Response;

/**
 * Class ReviewsController
 */
class ReviewsController extends BaseController
{
    /**
     * @return string[]
     * @throws Throwable
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
            Yii::$app->session->setFlash('success', Yii::t('app', 'review.thx'));
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
            Yii::$app->session->setFlash('success', Yii::t('app', 'review.has_deleted'));
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
            Yii::$app->session->setFlash('success', Yii::t('app', 'review.has_changed'));
        }
        return static::getSuccessResponse();
    }
}
