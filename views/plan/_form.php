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

    <?= $form->field($model, 'period')->textInput([
        'class' => 'form-control date-range-input'
    ]) ?>

    <?= $form->field($model, 'direction')->dropDownList($model::getDirectionsListItems(), ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? $this->t('Create') : $this->t('Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php PlanAsset::register($this);  ?>
<?php $this->registerJs('
    Plan.init();
'); ?>
