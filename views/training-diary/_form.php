<?php
/**
 * @var app\components\View $this
 * @var app\models\TrainingDiary $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="training-diary-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->textInput([
        'value' => $model->date ? $model->date : $this->getCurrentDate(),
        'class' => 'form-control date-input',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : ('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
