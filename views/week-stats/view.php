<?php
/**
 * @var app\components\View $this
 * @var app\models\WeekStats $model
 * @var yii\data\ArrayDataProvider $dataProvider
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

    <?= $this->render('@app/views/partials/_stats-days-list.php', [
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
