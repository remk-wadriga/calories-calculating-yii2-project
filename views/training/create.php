<?php
/**
 * $var app\components\View $this
 * @var app\models\Training $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create training');
$this->params['breadcrumbs'][] = ['label' => $this->t('Trainings'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="training-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
