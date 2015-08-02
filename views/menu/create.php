<?php
/**
 * @var app\components\View $this
 * @var app\models\Menu $model
 */

use yii\helpers\Html;

$this->title = $this->t('Create Menu');
$this->params['breadcrumbs'][] = ['label' => $this->t('Menu list'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
