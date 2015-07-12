<?php
/**
 * @var app\components\View $this
 * @var app\models\Product $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'calories')->textInput([
        'class' => 'form-control float-input',
        'value' => $model->calories ? $model->calories*100 : null,
    ]) ?>

    <?= $form->field($model, 'protein')->textInput([
        'class' => 'form-control float-input',
        'value' => $model->protein ? $model->protein*100 : null,
    ]) ?>

    <?= $form->field($model, 'fat')->textInput([
        'class' => 'form-control float-input',
        'value' => $model->fat ? $model->fat*100 : null,
    ]) ?>

    <?= $form->field($model, 'carbohydrate')->textInput([
        'class' => 'form-control float-input',
        'value' => $model->carbohydrate ? $model->carbohydrate*100 : null,
    ]) ?>

    <?= $form->field($model, 'categoryId')->dropDownList($model->getCategoryIdItems()) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
