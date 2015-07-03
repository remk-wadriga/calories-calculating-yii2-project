<?php
/**
 * @var app\components\View $this
 * @var app\models\Portion $model
 *
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="portion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

    <h4><?= $this->t('Ingredient') ?>:</h4>

    <?= $this->render('@app/views/partials/_ingredient-categories-dropdown-list', ['form' => $form, 'model' => $model]) ?>

    <div id="category_ingredients_field">
        <?php if($model->hasIngredient()): ?>
            <?= $this->render('@app/views/partials/_category-ingredients-dropdown-list', [
                'model' => $model,
                'form' => $form,
            ]) ?>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
