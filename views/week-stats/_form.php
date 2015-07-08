<?php
/**
 * @var app\components\View $this
 * @var app\models\WeekStats $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="week-stats-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'calories')->textInput() ?>

    <?= $form->field($model, 'average_weight')->textInput() ?>

    <?= $form->field($model, 'average_calories')->textInput() ?>

    <?= $form->field($model, 'body_weight')->textInput() ?>

    <?= $form->field($model, 'days_stats')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($this->t('Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
