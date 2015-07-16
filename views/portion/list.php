<?php
/**
 * @var app\components\View $this
 * @var app\repositories\PortionRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Portions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portion-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a($this->t('Create new portion'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a($this->t('By category'), ['/portion-category/list'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'categoryName',
            'weight',
            [
                'attribute' => 'calories',
                'value'  => function($model){
                    return $this->round($model->calories, 0);
                },
            ],
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
