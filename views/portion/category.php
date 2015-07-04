<?php
/**
 * @var app\components\View $this
 * @var app\repositories\PortionRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Portions');
$this->params['breadcrumbs'][] = ['label' => $this->t('Portion categories'), 'url' => ['/portion-category/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create portion'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'categoryName',
            [
                'label'  => $this->t('Calories'),
                'attribute' => 'calories',
                'value'  => function($model){
                    return $this->round($model->calories);
                },
            ],
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
