<?php
/**
 * @var app\components\View $this
 * @var app\models\Diary $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update diary record by {date}', ['date' => $model->date]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Diary'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="diary-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
