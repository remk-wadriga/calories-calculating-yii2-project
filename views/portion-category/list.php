<?php
/**
 * @var app\components\View $this
 * @var app\repositories\RecipeCategoryRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Portions categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create category'), ['/recipe-category/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'portionsCount',
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model){
                        $text = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($text, ['/portion/category', 'categoryId' => $model->id]);
                    },
                    'update' => function($url, $model){
                        $text = '<span class="glyphicon glyphicon-pencil"></span>';
                        return Html::a($text, ['/recipe-category/update', 'id' => $model->id]);
                    },
                    'delete' => function($url, $model){
                        $text = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($text, ['/recipe-category/delete', 'id' => $model->id], [
                            'title' => $this->t('Delete'),
                            'aria-label' => $this->t('Delete'),
                            'data' => [
                                'pjax' => 0,
                                'method' => 'post',
                                'confirm' => $this->t('Are you sure you want to delete this item') . '?',
                            ],
                        ]);
                    },
                ],
                'template'=>'{view} {update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
