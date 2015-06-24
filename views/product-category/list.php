<?php
/**
 * @var app\components\View $this
 * @var app\repositories\ProductCategoryRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Product categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model){
                        $text = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($text, ['product/category', 'categoryId' => $model->id]);
                    },
                ],
                'template'=>'{view} {update} {delete}',
            ],
        ],
    ]); ?>

</div>
