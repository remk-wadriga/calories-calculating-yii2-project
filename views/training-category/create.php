<?php
/**
 * @var app\components\View $this
 * @var app\models\TrainingCategory $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create training category');
$this->params['breadcrumbs'][] = ['label' => $this->t('Training categories'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
