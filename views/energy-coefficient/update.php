<?php
/**
 * @var app\components\View $this
 * @var app\models\EnergyCoefficient $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update energy coefficient "{value}"', ['value' => $model->value]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Energy coefficients'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="energy-coefficients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
