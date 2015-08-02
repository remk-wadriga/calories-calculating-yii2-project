<?php
/**
 * @var app\components\View $this
 * @var app\repositories\PortionRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Portions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a($this->t('Create new portion'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('By category'), ['/portion-category/list'], ['class' => 'btn btn-info']) ?>
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
                    return Html::a($model->categoryName, ['/portion/category', 'categoryId' => $model->recipeCategoryId]);
                },
                'attribute' => 'categoryName',
                'format' => 'raw',
            ],
            'weight',
            [
                'attribute' => 'calories',
                'value'  => function($model){
                    return $model->calories ? $this->round($model->calories, 0) : null;
                },
            ],
            [
                'attribute' => 'proteins',
                'value'  => function($model){
                    return $model->proteins ? $this->round($model->proteins, 0) : null;
                },
            ],
            [
                'attribute' => 'fats',
                'value'  => function($model){
                    return $model->fats ? $this->round($model->fats, 0) : null;
                },
            ],
            [
                'attribute' => 'carbohydrates',
                'value'  => function($model){
                    return $model->carbohydrates ? $this->round($model->carbohydrates, 0) : null;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
