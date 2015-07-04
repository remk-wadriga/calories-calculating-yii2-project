<?php
/**
 * @var app\components\View $this
 * @var app\repositories\DiaryRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Diary');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diary-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Add diary record'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            [
                'label'  => $this->t('Calories'),
                'attribute' => 'calories',
                'value'  => function($model){
                    return $this->round($model->calories);
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
