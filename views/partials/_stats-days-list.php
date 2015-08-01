<?php
/**
 * @var app\components\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<?php if($dataProvider->getCount() > 0): ?>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{$title}:<br />{items}",
        'columns' => [
            'date',
            [
                'value' => function($model){
                    return $model->dayName;
                },
                'attribute' => 'day',
            ],
            [
                'value' => function($model){
                    return $this->round($model->calories, 0);
                },
                'attribute' => 'calories'
            ],
            [
                'value' => function($model){
                    return $this->round($model->weight, 0);
                },
                'attribute' => 'weight'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model){
                        if($model->id > 0){
                            $text = '<span class="glyphicon glyphicon-eye-open"></span>';
                            return Html::a($text, ["/diary/view", 'id' => $model->id], [
                                'data' => ['pjax' => 0],
                            ]);
                        }else{
                            return '';
                        }
                    }
                ],
                'template' => '{view}',
            ]
        ],
    ]); ?>
    <?php Pjax::end(); ?>

<?php endif; ?>