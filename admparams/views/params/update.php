<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model app\models\Params */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('admparams', 'Update Params: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Adm::t('admparams', 'Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Adm::t('admparams', 'Update');
Yii::$app->i18n->resetDot();
?>
<div class="params-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
