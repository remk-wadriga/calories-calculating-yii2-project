<?php
/**
 * @var app\components\View $this
 * @var app\models\User $model
 */

use yii\helpers\Html;

$this->title = $this->t('Account settings');
$this->params['breadcrumbs'][] = ['label' => Yii::$app->user->name, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->t('Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>