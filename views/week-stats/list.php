<?php
/**
 * @var app\components\View $this
 * @var app\repositories\WeekStatsRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $this->t('Week stats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-stats-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'startDate',
            'endDate',
            [
                'label' => $this->t('Calories'),
                'attribute' => 'calories',
                'value' => function($model){
                    return $this->round($model->calories, 0);
                }
            ],
            [
                'label' => $this->t('Average calories'),
                'attribute' => 'averageCalories',
                'value' => function($model){
                    return $this->round($model->averageCalories, 0);
                }
            ],
            /*[
                'label' => $this->t('Weighing day'),
                'attribute' => 'weighingDay',
                'value' => function($model){
                    return $this->getDayName($model->weighingDay);
                }
            ],*/
            'bodyWeight',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model){
                        $text = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($text, ['week-stats/view', 'id' => $model->id]);
                    },
                    'update' => function($url, $model){
                        $text = '<span class="glyphicon glyphicon-pencil"></span>';
                        return Html::a($text, ['week-stats/update', 'id' => $model->id]);
                    }
                ],
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
