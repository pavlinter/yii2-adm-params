<?php

use pavlinter\admparams\Module;
use pavlinter\buttons\InputButton;
use yii\bootstrap\Alert;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model app\models\Params */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="params-form">

    <?php
    if (!$model->isNewRecord) {
        echo Alert::widget([
            'body' => Module::t('description', $model->name,['dot' => true]),
            'closeButton' => false,
            'options' => [
                'class' => 'alert-info',
            ],
        ]);
    }
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 250]) ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= InputButton::widget([
            'label' => $model->isNewRecord ? Adm::t('', 'Create', ['dot' => false]) : Adm::t('', 'Update', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'formSelector' => $form,
        ]);?>

        <?php if ($model->isNewRecord) {?>
            <?= InputButton::widget([
                'label' => Adm::t('', 'Create and insert new', ['dot' => false]),
                'options' => ['class' => 'btn btn-primary'],
                'input' => 'adm-redirect',
                'name' => 'redirect',
                'value' => Url::to(['create']),
                'formSelector' => $form,
            ]);?>
        <?php }?>

        <?= InputButton::widget([
            'label' => $model->isNewRecord ? Adm::t('', 'Create and list', ['dot' => false]) : Adm::t('', 'Update and list', ['dot' => false]),
            'options' => ['class' => 'btn btn-primary'],
            'input' => 'adm-redirect',
            'name' => 'redirect',
            'value' => Url::to(['index']),
            'formSelector' => $form,
        ]);?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
