<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model app\models\Params */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Adm::t('admparams', 'Create') : Adm::t('admparams', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
