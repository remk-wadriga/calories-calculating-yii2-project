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
            'id',
            'user_id',
            'date',
        ],
    ]) ?>

</div>
