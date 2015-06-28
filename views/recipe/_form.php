<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="recipe-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categoryId')->dropDownList($model->getCategoryIdItems()) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>

    <br />

    <h4><?= $this->t('Add ingredients') ?>:</h4>

    <?= $this->render('@app/views/partials/_product-categories-dropdown-list', ['form' => $form, 'model' => $model]) ?>

    <div id="category_products_field"></div>

    <br />

    <h4><?= $this->t('Products') ?>:</h4>
    <div id="products_list">
        <?php foreach($model->getIngredients() as $item): ?>
            <?= $this->render('@app/views/partials/_ingredient-line', [
                'model' => $model,
                'property' => 'productsItems',
                'ingredient' => [
                    'name' => $item['name'],
                    'weight' => $item['weight'],
                    'productsItems' => $item['id']
                ],
            ]) ?>
        <?php endforeach; ?>
    </div>

    <br />

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="product_prototype" class="hide">
        <?= $this->render('@app/views/partials/_ingredient-line', [
            'model' => $model,
            'property' => 'productsItems',
            'ingredient' => [
                'name' => '',
                'weight' => '',
                'productsItems' => ''
            ],
        ]) ?>
    </div>

</div>
