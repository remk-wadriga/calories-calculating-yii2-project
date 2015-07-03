<?php
/**
 * @var app\components\View $this
 * @var app\models\Portion $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update Portion "{portionName}"', ['portionName' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Portions'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="portion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
