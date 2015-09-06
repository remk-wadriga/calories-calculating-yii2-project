<?php

namespace app\controllers;

use Yii;
use app\models\Diary;
use app\models\Portion;
use app\models\Recipe;
use app\repositories\RecipeRepository;
use app\repositories\RecipeIngredientsRepository;
use app\abstracts\ControllerAbstract;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RecipeCategory;
use yii\widgets\ActiveForm;

/**
 * RecipeController implements the CRUD actions for Recipe model.
 */
class RecipeController extends ControllerAbstract
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
        $searchModel = new RecipeRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $searchModel = new RecipeIngredientsRepository();
        $searchModel->id = $id;
        $ingredientsDataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'model' => $this->findModel($id),
            'dataProvider' => $ingredientsDataProvider,
        ]);
    }

    public function actionCategory($categoryId)
    {
        $category = RecipeCategory::findOne($categoryId);
        if (empty($category)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->isAjax()) {
            $model = new Portion();
            $model->recipeCategoryId = $categoryId;
            return $this->renderPartial('@app/views/partials/_category-ingredients-dropdown-list', [
                'model' => $model,
                'form' => ActiveForm::begin(),
            ]);
        } else {
            $searchModel = new RecipeRepository();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render([
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'categoryName' => $category->name,
            ]);
        }
    }

    public function actionDiaryCategory($categoryId)
    {
        if (!$this->isAjax()) {
            throw new BadRequestHttpException();
        }

        $model = new Diary();
        $model->recipeCategoryId = $categoryId;

        return $this->renderPartial('@app/views/diary/_category-elements-dropdown-list', [
            'model' => $model,
            'form' => ActiveForm::begin(),
            'param' => 'recipesList',
            'items' => $model->getRecipeItems()
        ]);
    }

    public function actionCreate()
    {
        $model = new Recipe();

        if ($model->load($this->post()) && $model->saveRecipe()) {
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

        if ($model->load($this->post()) && $model->saveRecipe()) {
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
     * Finds the Recipe model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Recipe::findById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
