<?php
/**
 * @var \app\components\View $this
 * @var \app\forms\RegistrationForm $model
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = $this->t('Registration');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-registration">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= $this->t('Please fill out the following fields to sign up') ?>:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'retypePassword')->passwordInput() ?>

    <?= $form->field($model, 'firstName') ?>

    <?= $form->field($model, 'lastName') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'about')->textarea() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton($this->t('Sign up'), ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>



