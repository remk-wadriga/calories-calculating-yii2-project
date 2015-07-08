<?php
/**
 * @var app\components\View $this
 * @var app\models\WeekStats $model
 */

use yii\helpers\Html;

$this->title = $this->t('Set weight');
$this->params['breadcrumbs'][] = ['label' => $this->t('Week Stats'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->startDate . '-' . $model->endDate, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="week-stats-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
