<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $model app\models\Params */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('admparams', 'Create Params');
$this->params['breadcrumbs'][] = ['label' => Adm::t('admparams', 'Params'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="params-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
