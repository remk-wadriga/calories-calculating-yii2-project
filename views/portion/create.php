<?php
/**
 * @var app\components\View $this
 * @var app\models\Portion $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create Portion');
$this->params['breadcrumbs'][] = ['label' => $this->t('Portions'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="portion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
