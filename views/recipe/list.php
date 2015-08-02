<?php
/**
 * @var app\components\View $this
 * @var app\repositories\RecipeRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Recipes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create recipe'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('By category'), ['/recipe-category/list'], ['class' => 'btn btn-info']) ?>
        <?= Html::a($this->t('Create category'), ['/recipe-category/create'], ['class' => 'btn btn-primary']) ?>
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
                    return Html::a($model->categoryName, ['/recipe/category', 'categoryId' => $model->categoryId]);
                },
                'attribute' => 'categoryName',
                'format' => 'raw',
            ],
            [
                'attribute' => 'calories',
                'value'  => function($model){
                    return $model->calories ? $this->round($model->calories*100) : null;
                },
            ],
            [
                'attribute' => 'proteins',
                'value'  => function($model){
                    return $model->proteins ? $this->round($model->proteins*100) : null;
                },
            ],
            [
                'attribute' => 'fats',
                'value'  => function($model){
                    return $model->fats ? $this->round($model->fats*100) : null;
                },
            ],
            [
                'attribute' => 'carbohydrates',
                'value'  => function($model){
                    return $model->carbohydrates ? $this->round($model->carbohydrates*100) : null;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
