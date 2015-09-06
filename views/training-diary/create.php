<?php
/**
 * @var app\components\View $this
 * @var app\models\TrainingDiary $model
 */

use yii\helpers\Html;

$this->title = $this->t('Add diary record');
$this->params['breadcrumbs'][] = ['label' => $this->t('Trainings diary'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-diary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
