<?php
/**
 * @var app\components\View $this
 * @var app\models\User $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\WeekStats;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'newPassword')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'startWeight')->textInput() ?>

    <?= $form->field($model, 'plannedCalories')->textInput() ?>

    <br />

    <?= $form->field($model, 'weighingDay')->dropDownList(Yii::$app->statsService->getWeekDays()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>