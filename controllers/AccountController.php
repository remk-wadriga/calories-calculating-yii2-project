<?php

namespace app\controllers;

use Yii;
use app\abstracts\ControllerAbstract;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class AccountController extends ControllerAbstract
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException();
        }

        return true;
    }

    public function actionView()
    {
        $model = $this->getModel();

        return $this->render([
            'model' => $model,
        ]);
    }

    public function actionUpdate()
    {
        $model = $this->getModel();

        if ($model->load($this->post()) && $model->save()) {
            $this->redirect(['view']);
        }

        return $this->render([
            'model' => $model,
        ]);
    }

    /**
     * @return null|\app\models\User
     */
    public function getModel()
    {
        return Yii::$app->getUser()->getIdentity();
    }
}