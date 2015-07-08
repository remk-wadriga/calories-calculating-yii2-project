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

            'id',
            'user_id',
            'start_date',
            'end_date',
            'weight',
            // 'calories',
            // 'average_weight',
            // 'average_calories',
            // 'body_weight',
            // 'days_stats:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
