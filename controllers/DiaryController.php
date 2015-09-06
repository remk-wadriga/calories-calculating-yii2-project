<?php

namespace app\controllers;

use Yii;
use app\abstracts\ControllerAbstract;
use app\models\Diary;
use app\repositories\DiaryRepository;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\repositories\DiaryProductIngredientRepository;
use app\repositories\DiaryRecipeIngredientRepository;
use app\repositories\DiaryPortionIngredientRepository;

/**
 * DiaryController implements the CRUD actions for Diary model.
 */
class DiaryController extends ControllerAbstract
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

    public function actionList()
    {
        $searchModel = new DiaryRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $productIngredientModel = new DiaryProductIngredientRepository();
        $recipeIngredientModel = new DiaryRecipeIngredientRepository();
        $portionIngredientModel = new DiaryPortionIngredientRepository();

        $productIngredientModel->id = $id;
        $recipeIngredientModel->id = $id;
        $portionIngredientModel->id = $id;

        return $this->render([
            'model' => $this->findModel($id),
            'productsDataProvider' => $productIngredientModel->search(),
            'recipesDataProvider' => $recipeIngredientModel->search(),
            'portionsDataProvider' => $portionIngredientModel->search(),
        ]);
    }

    public function actionCreate()
    {
        $model = new Diary();

        // Set the write weighing day event handler
        $model->on(Diary::WRITE_WEIGHING_DAY_EVENT, [Yii::$app->statsService, 'onWeighingDayWrite']);

        if ($model->load($this->post()) && $model->diarySave()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->post()) && $model->diarySave()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the Diary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Diary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Diary::findById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
