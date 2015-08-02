<?php
/**
 * @var app\components\View $this
 * @var app\models\Plan $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create Plan');
$this->params['breadcrumbs'][] = ['label' => $this->t('Plan list'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
