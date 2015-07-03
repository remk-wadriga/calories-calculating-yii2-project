<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe|app\models\Portion $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?= $form->field($model, $model->getIngredientName() . 'sItems')->dropDownList($model->getIngredientsListItems(), [
    'class' => 'form-control add-product-select',
    'data' => [
        'target' => '#ingredients_list',
        'prototype' => '#ingredient_prototype',
    ],
]) ?>