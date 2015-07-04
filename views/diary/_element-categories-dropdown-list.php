<?php
/**
 * @var app\components\View $this
 * @var app\models\Diary
 * @var yii\widgets\ActiveForm $form
 * @var string $element
 * @var array $categories
 */
?>

<?= $form->field($model, $element . 'CategoryId')->dropDownList($categories, [
    'class' => 'form-control dropdown-sublist-ajx',
    'data' => [
        'target' => '#category_' . $element . '_field',
        'url' => $element . '/diary-category',
        'param' => 'categoryId'
    ],
]) ?>
