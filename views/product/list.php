<?php
/**
 * @var app\components\View $this
 * @var app\repositories\ProductRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create product'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('By category'), ['/product-category/list'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'calories' => [
                'label' => $this->t('Calories'),
                'value' => function($model){
                    return $model->calories ? $this->round($model->calories*100) : null;
                },
                'attribute' => 'calories',
            ],
            [
                'label' => $this->t('Proteins'),
                'value' => function($model){
                    return $model->protein ? $this->round($model->protein*100) : null;
                },
                'attribute' => 'protein',
            ],
            [
                'label' => $this->t('Fats'),
                'value' => function($model){
                    return $model->fat ? $this->round($model->fat*100) : null;
                },
                'attribute' => 'fat',
            ],
            [
                'label' => $this->t('Carbohydrates'),
                'value' => function($model){
                    return $model->carbohydrate ? $this->round($model->carbohydrate*100) : null;
                },
                'attribute' => 'carbohydrate',
            ],
            'categoryName',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
