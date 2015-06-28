<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe|app\models\Portion $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<?= $form->field($model, 'productsItems')->dropDownList($model->getProductsListItems(), [
    'class' => 'form-control add-product-select',
    'data' => [
        'target' => '#products_list',
        'prototype' => '#product_prototype',
    ],
]) ?>