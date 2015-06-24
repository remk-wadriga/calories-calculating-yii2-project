<?php
/**
 * @var app\components\View $this
 * @var app\models\Product $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create product');
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
