<?php

namespace app\controllers;

use app\models\Diary;
use Yii;
use app\models\Portion;
use app\repositories\PortionRepository;
use app\abstracts\ControllerAbstract;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\RecipeCategory;
use yii\widgets\ActiveForm;

/**
 * PortionController implements the CRUD actions for Portion model.
 */
class PortionController extends ControllerAbstract
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
     * Lists all Portion models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new PortionRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Portion model.
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

        $searchModel = new PortionRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryName' => $category->name,
        ]);
    }

    public function actionDiaryCategory($categoryId)
    {
        if (!$this->isAjax()) {
            throw new BadRequestHttpException();
        }

        $model = new Diary();
        $model->portionCategoryId = $categoryId;

        return $this->renderPartial('@app/views/diary/_category-elements-dropdown-list', [
            'model' => $model,
            'form' => ActiveForm::begin(),
            'param' => 'portionsList',
            'items' => $model->getPortionItems()
        ]);
    }

    /**
     * Creates a new Portion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Portion();

        if ($model->load($this->post()) && $model->savePortion()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Portion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($this->post()) && $model->savePortion()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Portion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the Portion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Portion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Portion::findById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
