<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe|app\models\Portion $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?= $form->field($model, $model->getIngredientName() . 'CategoryId')->dropDownList($model->getIngredientsCategoriesListItems(), [
    'class' => 'form-control dropdown-sublist-ajx',
    'data' => [
        'target' => '#category_ingredients_field',
        'url' => $model->getIngredientName() . '/category',
        'param' => 'categoryId'
    ],
]) ?>
