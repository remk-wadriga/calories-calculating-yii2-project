<?php
/**
 * @var app\components\View $this
 * @var app\models\Product $model
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->t('Products'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create new product'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'calories' => [
                'value' => $model->calories !== null ? $this->round($model->calories*100) : null,
                'attribute' => 'calories',
            ],
            [
                'value' => $model->protein !== null ? $this->round($model->protein*100) : null,
                'attribute' => 'protein',
            ],
            [
                'value' => $model->fat !== null ? $this->round($model->fat*100) : null,
                'attribute' => 'fat',
            ],
            [
                'value' => $model->carbohydrate !== null ? $this->round($model->carbohydrate*100) : null,
                'attribute' => 'carbohydrate',
            ],
            [
                'value' => Html::a($model->categoryName, ['/product/category', 'categoryId' => $model->categoryId]),
                'attribute' => 'categoryName',
                'format' => 'raw'
            ],
            'description:ntext',
        ],
    ]) ?>

</div>
