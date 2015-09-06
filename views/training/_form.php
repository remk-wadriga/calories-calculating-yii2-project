<?php
/**
 * @var app\components\View $this
 * @var app\models\Training $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="training-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoryId')->dropDownList($model->getCategoryIdItems()) ?>

    <?= $form->field($model, 'calories')->textInput([
        'class' => 'form-control float-input',
        'value' => $model->calories ? $this->round($model->calories/3600) : null,
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
