<?php
/**
 * @var app\components\View $this
 * @var app\models\User $model
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $this->t('My account');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="account-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a($this->t('Update'), ['update'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email',
            'firstName',
            'lastName',
            'phone',
            'startWeight',
            'plannedCalories',
            [
                'label' => $model->getAttributeLabel('weighingDay'),
                'value' => $this->getDayName($model->weighingDay),
            ],
        ],
    ]) ?>

</div>

