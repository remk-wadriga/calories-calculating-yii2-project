<?php
/**
 * @var app\components\View $this
 * @var app\repositories\ProductRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var string $categoryName
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Products of category "{categoryName}"', ['categoryName' => $categoryName]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Product categories'), 'url' => ['/product-category/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create product'), ['create'], ['class' => 'btn btn-success']) ?>
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
