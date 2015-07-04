<?php
/**
 * @var app\components\View $this
 * @var app\models\Diary $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="diary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $this->render('_element-categories-dropdown-list', [
        'form' => $form,
        'model' => $model,
        'element' => 'portion',
        'categories' => $model->getRecipeCategoriesItems()
    ]) ?>
    <div id="category_portion_field"></div>

    <?= $this->render('_element-categories-dropdown-list', [
        'form' => $form,
        'model' => $model,
        'element' => 'recipe',
        'categories' => $model->getRecipeCategoriesItems()
    ]) ?>
    <div id="category_recipe_field"></div>

    <?= $this->render('_element-categories-dropdown-list', [
        'form' => $form,
        'model' => $model,
        'element' => 'product',
        'categories' => $model->getProductCategoriesItems()
    ]) ?>
    <div id="category_product_field"></div>

    <br />

    <h4><?= $this->t('Portions') ?>:</h4>
    <div id="portionsList_items">

    </div>

    <h4><?= $this->t('Dishes') ?>:</h4>
    <div id="recipesList_items">

    </div>

    <h4><?= $this->t('Products') ?>:</h4>
    <div id="productsList_items">

    </div>

    <br />

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div id="portionsList_prototype" class="hide">
        <?= $this->render('@app/views/partials/_ingredient-line', [
            'model' => $model,
            'property' => 'portionsList',
            'ingredient' => [
                'name' => '',
                'count' => '',
                'productsItems' => ''
            ],
        ]) ?>
    </div>

    <div id="recipesList_prototype" class="hide">
        <?= $this->render('@app/views/partials/_ingredient-line', [
            'model' => $model,
            'property' => 'recipesList',
            'ingredient' => [
                'name' => '',
                'weight' => '',
                'productsItems' => ''
            ],
        ]) ?>
    </div>

    <div id="productsList_prototype" class="hide">
        <?= $this->render('@app/views/partials/_ingredient-line', [
            'model' => $model,
            'property' => 'productsList',
            'ingredient' => [
                'name' => '',
                'weight' => '',
                'productsItems' => ''
            ],
        ]) ?>
    </div>

</div>
