<?php
/**
 * @var app\components\View $this
 * @var app\models\Menu $model
 */

use yii\helpers\Html;

$this->title = $this->t('Update mnu {menuName}', ['menuName' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => $this->t('Menu list'), 'url' => ['list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="menu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
