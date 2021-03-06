<?php
/**
 * @var app\components\View $this
 * @var app\models\Plan $model
 * @var yii\widgets\ActiveForm $form
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\PlanAsset;
?>

<div class="plan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'startDate')->textInput([
        'id' => 'plan_start_date_input',
        'value' => $model->startDate ? $model->startDate : $this->getCurrentDate(),
        'class' => 'form-control date-input',
    ]) ?>

    <?= $form->field($model, 'endDate')->textInput([
        'id' => 'plan_end_date_input',
        'value' => $model->endDate ? $model->endDate : null,
        'class' => 'form-control date-input',
    ]) ?>

    <?= $form->field($model, 'direction')->dropDownList($model::getDirectionsListItems()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php PlanAsset::register($this);  ?>
<?php $this->registerJs('
    Plan.init({
        startAndDatesError: "' . $this->t('Start date can not be less than the period-end', [], 'error') . '"
    });
'); ?>
