<?php
/**
 * @var app\components\View $this
 * @var app\models\WeekStats $model
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->startDate . ' - ' . $model->endDate;
$this->params['breadcrumbs'][] = ['label' => $this->t('Week stats'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-stats-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'startDate',
            'endDate',
            'calories',
            [
                'label' => $model->getAttributeLabel('averageCalories'),
                'value' => $this->round($model->averageCalories, 0),
            ],
            [
                'label' => $model->getAttributeLabel('weighingDay'),
                'value' => $this->getDayName($model->weighingDay),
            ],
            'bodyWeight',
        ],
    ]) ?>

    <?php  if($model->getDays()): ?>
        <br />

        <h4><?= $this->t('Days stats') ?>:</h4>

        <table class="table table-striped table-bordered detail-view">
            <thead>
            <tr>
                <th><?= $this->t('Date') ?></th>
                <th><?= $this->t('Day') ?></th>
                <th><?= $this->t('Calories') ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($model->getDays() as $day): ?>
                <tr>
                    <td><?= $day->date ?></td>
                    <td><?= $day->deyName ?></td>
                    <td><?= $this->round($day->calories, 0) ?></td>
                    <td><?= $day->id > 0 ? Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['/diary/view', 'id' => $day->id]) : '' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
