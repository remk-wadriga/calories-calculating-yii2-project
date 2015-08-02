<?php
/**
 * @var app\components\View $this
 * @var app\models\Plan $model
 */

use yii\helpers\Html;

$title = $model->startDate . ' - ' . $model->endDate;
$this->title = $this->t('Update plan {planDates}', ['planDates' => $title]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Plan list'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $this->t('Plan {planDates}', ['planDates' => $title]), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="plan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
