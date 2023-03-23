<?php

namespace frontend\controllers;

use common\models\LoginForm;
use common\models\UserDetails;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\user\ChangePasswordForm;
use frontend\models\user\EditUserForm;
use frontend\models\VerifyEmailForm;
use Throwable;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'account'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash(
                'success',
                Yii::t('app', 'signup.success')
            );
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'request_password_reset.success')
                );

                return $this->goHome();
            }

            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'request_password_reset.error')
            );
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())
            && $model->validate()
            && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'password.reset.success'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail())
            && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'email.verify.success'));
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', Yii::t('app', 'email.verify.error'));
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post())
            && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash(
                    'success',
                    Yii::t('app', 'email.resend.verify.success')
                );
                return $this->goHome();
            }
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'email.resend.verify.error')
            );
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * @return string[]
     */
    public function actionChangePassword()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new ChangePasswordForm();
        $form->load(Yii::$app->request->post(), '');

        if (!$form->change()) {
            Yii::$app->session->setFlash('error', $form->getErrors('error'));
            return static::getErrorResponse();
        } else {
            Yii::$app->session->setFlash('success', Yii::t('app', 'password.changed.success'));
        }
        return static::getSuccessResponse();
    }

    /**
     * @return string
     * @throws Throwable
     */
    public function actionAccount()
    {
        $user = Yii::$app->user->getIdentity();
        return $this->render('account', [
            'user' => $user,
            'details' => UserDetails::findOne(['user_id' => $user->id]) ?? new UserDetails()
        ]);
    }

    /**
     * @return string[]
     */
    public function actionEditUser()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new EditUserForm();
        $form->load(Yii::$app->request->post(), '');
        if (!$form->save()) {
            Yii::$app->session->setFlash('error', $form->getErrors('error'));
            return static::getErrorResponse();
        } else {
            Yii::$app->session->setFlash('success', Yii::t('app', 'user.edit.success'));
        }
        return static::getSuccessResponse();
    }
}
