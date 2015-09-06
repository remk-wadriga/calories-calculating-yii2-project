<?php
/**
 * @var app\components\View $this
 * @var app\models\TrainingDiary $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update trainings diary record {date}', ['date' => $model->date]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Trainings diary'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="training-diary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
