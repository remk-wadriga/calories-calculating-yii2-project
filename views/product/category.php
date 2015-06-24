<?php
/**
 * @var app\components\View $this
 * @var app\repositories\ProductRepository $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var string $categoryName
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = $this->t('Products of category "{categoryName}"', ['categoryName' => $categoryName]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Create product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'calories',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
