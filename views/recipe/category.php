<?php
/**
 * @var app\components\View $this
 * @var app\repositories\RecipeRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var string $categoryName
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Recipes of category "{categoryName}"', ['categoryName' => $categoryName]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Recipe categories'), 'url' => ['/recipe-category/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create recipe'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'calories',
                'value'  => function($model){
                    return $model->calories ? $this->round($model->calories*100) : null;
                },
            ],
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
