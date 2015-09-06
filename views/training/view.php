<?php
/**
 * @var app\components\View $this
 * @var app\models\Training $model
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->t('Trainings'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a($this->t('Create'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
                'value' => function($model){
                    return $model->calories !== null ? $this->round($model->calories/3600) : null;
                },
                'attribute' => 'calories',
            ],
            'categoryName',
            'description:ntext',
        ],
    ]) ?>

</div>
