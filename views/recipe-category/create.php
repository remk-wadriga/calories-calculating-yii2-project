<?php
/**
 * @var app\components\View $this
 * @var app\models\RecipeCategory $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create recipe category');
$this->params['breadcrumbs'][] = ['label' => $this->t('Recipe categories'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
