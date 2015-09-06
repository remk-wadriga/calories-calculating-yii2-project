<?php

namespace app\controllers;

use app\models\Diary;
use app\models\Portion;
use app\models\ProductCategory;
use app\models\Recipe;
use Yii;
use app\abstracts\ControllerAbstract;
use app\models\Product;
use app\repositories\ProductRepository;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends ControllerAbstract
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
        $searchModel = new ProductRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render([
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCategory($categoryId)
    {
        $category = ProductCategory::findOne($categoryId);
        if (empty($category)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($this->isAjax()) {
            $model = new Recipe();
            $model->productCategoryId = $categoryId;
            return $this->renderPartial('@app/views/partials/_category-ingredients-dropdown-list', [
                'model' => $model,
                'form' => ActiveForm::begin(),
            ]);
        } else {
            $params = Yii::$app->request->queryParams;
            $params['categoryId'] = $categoryId;

            $searchModel = new ProductRepository();
            $dataProvider = $searchModel->search($params);

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
        $model->productCategoryId = $categoryId;

        return $this->renderPartial('@app/views/diary/_category-elements-dropdown-list', [
            'model' => $model,
            'form' => ActiveForm::begin(),
            'param' => 'productsList',
            'items' => $model->getProductItems()
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findById($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
