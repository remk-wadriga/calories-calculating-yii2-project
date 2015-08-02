<?php
/**
 * @var app\components\View $this
 * @var app\models\Portion $model
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->t('Portions'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create new portion'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a($this->t('Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => $this->t('Are you sure you want to delete this item') . '?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'value' => Html::a($model->categoryName, ['/portion/category', 'categoryId' => $model->recipeCategoryId]),
                'attribute' => 'categoryName',
                'format' => 'raw',
            ],
            'weight',
            [
                'value'  => $this->round($model->calories, 0),
                'attribute' => 'calories',
            ],
            [
                'value'  => $this->round($model->proteins, 0),
                'attribute' => 'proteins',
            ],
            [
                'value'  => $this->round($model->fats, 0),
                'attribute' => 'fats',
            ],
            [
                'value'  => $this->round($model->carbohydrates, 0),
                'attribute' => 'carbohydrates',
            ],
            'description:ntext',
            [
                'label' => $this->t('Dish'),
                'value' => Html::a($model->recipeName, ['/recipe/view', 'id' => $model->recipeId]),
                'format' => 'raw'
            ]
        ],
    ]) ?>

</div>
