<?php
/**
 * @var app\components\View $this
 * @var app\repositories\RecipeRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var string $categoryName
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Recipes of category "{categoryName}"', ['categoryName' => $categoryName]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create recipe'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'categoryName',
            [
                'label'  => $this->t('Calories'),
                'attribute' => 'calories',
                'value'  => function($model){
                    return $this->round($model->calories);
                },
            ],
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
