<?php
/**
 * $var app\components\View $this
 * @var app\repositories\TrainingRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var string $categoryName
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Trainings of category "{categoryName}"', ['categoryName' => $categoryName]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Training categories'), 'url' => ['/training-category/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create training'), ['create'], ['class' => 'btn btn-success']) ?>
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
