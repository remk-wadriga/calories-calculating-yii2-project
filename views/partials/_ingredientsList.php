<?php
/**
 * @var app\components\View $this
 * @var yii\data\ArrayDataProvider $dataProvider
 * @var string $modelName
 * @var string $title
 * @var string $countAttribute
 */

use yii\helpers\Html;
use yii\grid\GridView;
use app\entities\IngredientEntity;
use yii\widgets\Pjax;
?>

<?php if($dataProvider->getCount() > 0): ?>

    <?php
        if(!isset($title)){
            $title = $this->t('Ingredients');
        }
        if(!isset($countAttribute)){
            $countAttribute = 'weight';
        }
    ?>

    <?php Pjax::begin(['enablePushState' => false]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{$title}:<br />{items}",
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 3%'],
            ],

            [
                'attribute' => 'name',
                'contentOptions' => ['style' => 'width: 40%'],
            ],
            [
                'value' => function($model){
                    return $model->type == IngredientEntity::TYPE_WEIGHT ? $this->round($model->weight) : $this->round($model->count);
                },
                'attribute' => $countAttribute,
                'contentOptions' => ['style' => 'width: 25%'],
            ],
            [
                'value' => function($model){
                    return $this->round($model->calories);
                },
                'attribute' => 'calories',
                'contentOptions' => ['style' => 'width: 25%'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function($url, $model)use($modelName){
                        $text = '<span class="glyphicon glyphicon-eye-open"></span>';
                        return Html::a($text, ["/{$modelName}/view", 'id' => $model->id]);
                    },
                    'update' => function($url, $model)use($modelName){
                        $text = '<span class="glyphicon glyphicon-pencil"></span>';
                        return Html::a($text, ["/{$modelName}/update", 'id' => $model->id]);
                    },
                    'delete' => function($url, $model)use($modelName){
                        $text = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($text, ["/{$modelName}/delete", 'id' => $model->id]);
                    },
                ],
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

<?php endif; ?>