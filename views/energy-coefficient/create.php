<?php
/**
 * @var app\components\View $this
 * @var app\models\EnergyCoefficient $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create energy coefficient');
$this->params['breadcrumbs'][] = ['label' => $this->t('Energy coefficients'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-coefficients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
