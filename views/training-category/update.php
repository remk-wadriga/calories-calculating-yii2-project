<?php
/**
 * @var app\components\View $this
 * @var app\models\TrainingCategory $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update training category {categoryName}', ['categoryName' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Training categories'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="training-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
