<?php
/**
 * @var app\components\View $this
 * @var app\models\Product $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update product') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->t('Products'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] =  $this->t('Update');
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
