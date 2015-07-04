<?php

namespace app\controllers;

use Yii;
use app\abstracts\ControllerAbstract;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\repositories\RecipeCategoryRepository;

class PortionCategoryController extends ControllerAbstract
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionList()
    {
        $searchModel = new RecipeCategoryRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}