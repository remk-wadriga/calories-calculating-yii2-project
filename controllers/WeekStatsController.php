<?php

namespace app\controllers;

use Yii;
use app\abstracts\ControllerAbstract;
use app\models\WeekStats;
use app\repositories\WeekStatsRepository;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeekStatsController implements the CRUD actions for WeekStats model.
 */
class WeekStatsController extends ControllerAbstract
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

    /**
     * Lists all WeekStats models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new WeekStatsRepository();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render([
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeekStats model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render([
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($date)
    {
        if (!$this->isPost()) {
            throw new BadRequestHttpException();
        }

        if (Yii::$app->statsService->writeStats($date)) {
            $this->setFlash('stats_status_flash', 'Statistics updated');
        } else {
            $this->setFlash('stats_status_flash', 'Failed to update the statistics');
        }

        return $this->redirect(['/week-stats/list']);
    }

    /**
     * Updates an existing WeekStats model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
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

    /**
     * Finds the WeekStats model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WeekStats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeekStats::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
