<?php
/**
 * @var app\components\View $this
 * @var app\repositories\EnergyCoefficientRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Energy coefficients');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-coefficients-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create energy coefficient'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'value',
            'coefficient',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
