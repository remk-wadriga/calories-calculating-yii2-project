<?php
/**
 * @var app\components\View $this
 * @var app\models\Portion|app\models\Recipe|app\models\Product $model
 * @var yii\widgets\ActiveForm $form
 * @var string $param
 * @var array $items
 */
?>

<?= $form->field($model, $param)->dropDownList($items, [
    'class' => 'form-control add-product-select',
    'data' => [
        'target' => '#' . $param . '_items',
        'prototype' => '#' . $param . '_prototype',
    ],
]) ?>