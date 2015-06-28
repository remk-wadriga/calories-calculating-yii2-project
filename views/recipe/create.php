<?php
/**
 * @var app\components\View $this
 * @var app\models\Recipe $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create recipe');
$this->params['breadcrumbs'][] = ['label' => $this->t('Recipes'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recipe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
