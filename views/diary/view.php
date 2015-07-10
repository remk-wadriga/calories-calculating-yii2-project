<?php
/**
 * @var app\components\View $this
 * @var app\models\Diary $model
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
                'label'  => $this->t('Calories'),
                'value'  => $this->round($model->calories, 0),
            ],
            [
                'label'  => $this->t('Day'),
                'value'  => $this->getDayName($model->day),
            ],
        ],
    ]) ?>

    <br />

    <table class="table table-striped table-bordered detail-view">
        <tbody>
            <?php $portionIngredients = $model->getPortionIngredients() ?>
            <?php if (!empty($portionIngredients)): ?>
                <tr>
                    <td><?= $this->t('Portions') ?></td>
                    <?= $this->render('_ingredients-line', ['ingredients' => $portionIngredients, 'url' => '/portion/view']) ?>
                </tr>
            <?php endif ?>
            <?php $recipesIngredients = $model->getRecipeIngredients() ?>
            <?php if (!empty($recipesIngredients)): ?>
                <tr>
                    <td><?= $this->t('Dishes') ?></td>
                    <?= $this->render('_ingredients-line', ['ingredients' => $recipesIngredients, 'url' => '/recipe/view']) ?>
                </tr>
            <?php endif ?>
            <?php $productIngredients = $model->getProductIngredients() ?>
            <?php if (!empty($productIngredients)): ?>
                <tr>
                    <td><?= $this->t('Products') ?></td>
                    <?= $this->render('_ingredients-line', ['ingredients' => $productIngredients, 'url' => '/product/view']) ?>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

    <p>
        <?= Html::a($this->t('Write to stats'), ['/week-stats/create', 'date' => $model->date], ['class' => 'btn btn-primary', 'data' => ['method' => 'post']]) ?>
    </p>

</div>
