<?php
/**
 * @var app\components\View $this
 * @var app\repositories\ProductRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create product'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('By category'), ['/product-category/list'], ['class' => 'btn btn-info']) ?>
        <?= Html::a($this->t('Create category'), ['/product-category/create'], ['class' => 'btn btn-primary']) ?>
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
                    return $model->calories !== null ? $this->round($model->calories*100) : null;
                },
                'attribute' => 'calories',
            ],
            [
                'value' => function($model){
                    return $model->protein !== null ? $this->round($model->protein*100) : null;
                },
                'attribute' => 'protein',
            ],
            [
                'value' => function($model){
                    return $model->fat !== null ? $this->round($model->fat*100) : null;
                },
                'attribute' => 'fat',
            ],
            [
                'value' => function($model){
                    return $model->carbohydrate !== null ? $this->round($model->carbohydrate*100) : null;
                },
                'attribute' => 'carbohydrate',
            ],
            [
                'value' => function($model){
                    return Html::a($model->categoryName, ['/product/category', 'categoryId' => $model->categoryId]);
                },
                'attribute' => 'categoryName',
                'format' => 'raw'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
