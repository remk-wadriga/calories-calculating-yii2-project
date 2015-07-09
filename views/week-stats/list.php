<?php
/**
 * @var app\components\View $this
 * @var app\repositories\WeekStatsRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Week stats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-stats-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'startDate',
            'endDate',
            'calories',
            'averageCalories',
            'bodyWeight',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
