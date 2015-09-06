<?php
/**
 * @var app\components\View $this
 * @var app\repositories\TrainingRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Trainings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create training'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('By category'), ['/training-category/list'], ['class' => 'btn btn-info']) ?>
        <?= Html::a($this->t('Create category'), ['/training-category/create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'value' => function($model){
                    return $model->calories !== null ? $this->round($model->calories/3600) : null;
                },
                'attribute' => 'calories',
            ],
            'categoryName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
