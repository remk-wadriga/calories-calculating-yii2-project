<?php
/**
 * @var app\components\View $this
 * @var app\models\RecipeCategory $model
 */

use yii\helpers\Html;

$this->t('Update recipe category "{categoryName}"', ['categoryName' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Recipe categories'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="recipe-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
