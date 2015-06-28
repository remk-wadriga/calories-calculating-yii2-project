<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe|app\models\Portion $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?= $form->field($model, 'productCategoryId')->dropDownList($model->getProductCategoriesListItems(), [
    'class' => 'form-control dropdown-sublist-ajx',
    'data' => [
        'target' => '#category_products_field',
        'url' => 'product/category',
        'param' => 'categoryId'
    ],
]) ?>
