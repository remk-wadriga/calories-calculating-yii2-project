<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe|app\models\Portion $model
 * @var yii\widgets\ActiveForm $form
 * @var array $ingredient
 * @var string $property
 */
use yii\helpers\Html;
?>

<div class="form-group">
    <h4>
        <?= Html::activeTextInput($model, $property, [
            'class' => 'form-control ingredient',
            'value' => isset($ingredient['count']) ? $ingredient['count'] : $ingredient['weight'],
            'name' => $model->modelName() . '[' . $property . '][' . $ingredient[$property] . ']',
            'placeholder' => isset($ingredient['count']) ? $this->t('Count') : $this->t('Weight'),
        ]) ?>
        <span class="label label-success"><?= $ingredient['name'] ?></span>
        <button class="btn label label-danger remove-parent-element" data-parent=".form-group" type="button"><i class="glyphicon glyphicon-remove"></i></button>
    </h4>
</div>