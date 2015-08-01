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

    <?= $form->field($model, 'bodyWeight')->textInput(['class' => 'form-control float-input']) ?>

    <div class="form-group">
        <?= Html::submitButton($this->t('Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
