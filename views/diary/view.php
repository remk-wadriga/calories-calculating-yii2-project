<?php
/**
 * @var app\components\View $this
 * @var app\models\Diary $model
 * @var yii\data\ArrayDataProvider $productsDataProvider
 * @var yii\data\ArrayDataProvider $recipesDataProvider
 * @var yii\data\ArrayDataProvider $portionsDataProvider
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->date;
$this->params['breadcrumbs'][] = ['label' => $this->t('Diary'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diary-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Add diary record'), ['create'], ['class' => 'btn btn-success']) ?>
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
            'date',
            [
                'value'  => $this->round($model->calories, 0),
                'attribute' => 'calories',
            ],
            [
                'value'  => $this->getDayName($model->day),
                'attribute' => 'day',
            ],
        ],
    ]) ?>

    <?= $this->render('@app/views/partials/_ingredientsList', [
        'dataProvider' => $productsDataProvider,
        'modelName' => 'product',
        'title' => $this->t('Products')
    ]) ?>

    <?= $this->render('@app/views/partials/_ingredientsList', [
        'dataProvider' => $recipesDataProvider,
        'modelName' => 'recipe',
        'title' => $this->t('Recipes')
    ]) ?>

    <?= $this->render('@app/views/partials/_ingredientsList', [
        'dataProvider' => $portionsDataProvider,
        'modelName' => 'portion',
        'title' => $this->t('Portions'),
        'countAttribute' => 'count',
    ]) ?>

    <p>
        <?= Html::a($this->t('Write to stats'), ['/week-stats/create', 'date' => $model->date], ['class' => 'btn btn-primary', 'data' => ['method' => 'post']]) ?>
    </p>

</div>
