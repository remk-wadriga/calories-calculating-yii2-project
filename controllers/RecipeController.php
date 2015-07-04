<?php

namespace app\controllers;

use app\models\Diary;
use app\models\Portion;
use Yii;
use app\models\Recipe;
use app\repositories\RecipeRepository;
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

    /**
     * Lists all Recipe models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new RecipeRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Recipe model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render([
            'model' => $this->findModel($id),
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

    /**
     * Creates a new Recipe model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
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

    /**
     * Updates an existing Recipe model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing Recipe model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
