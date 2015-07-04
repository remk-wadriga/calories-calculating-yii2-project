<?php
/**
 * @var app\components\View $this
 * @var app\models\Diary $model
 */

use yii\helpers\Html;

$this->title = $this->t('Add diary record');
$this->params['breadcrumbs'][] = ['label' => $this->t('Diary'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
