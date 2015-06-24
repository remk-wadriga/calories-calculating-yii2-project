<?php
/**
 * @var app\components\View $this
 * @var app\models\ProductCategory $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create category');
$this->params['breadcrumbs'][] = ['label' => $this->t('Product categories'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
