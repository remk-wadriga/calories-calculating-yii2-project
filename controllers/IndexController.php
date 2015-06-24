<?php

namespace app\controllers;

use Yii;
use app\abstracts\ControllerAbstract;
use app\forms\RegistrationForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\forms\LoginForm;

class IndexController extends ControllerAbstract
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        return $this->render();
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load($this->post()) && $model->registration()) {
            Yii::$app->user->login($model->getUser(), Yii::$app->params['userLoginTime']);
            return $this->goBack();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load($this->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception === null) {
            die;
        }

        $this->render([
            'name' => 'Error',
            'message' => $exception->getMessage(),
            'exception' => $exception,
        ]);
    }
}
