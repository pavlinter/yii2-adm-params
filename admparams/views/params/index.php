<?php

use yii\helpers\Html;
use pavlinter\adm\Adm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

Yii::$app->i18n->disableDot();
$this->title = Adm::t('admparams', 'Params');
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->i18n->resetDot();
?>
<div class="params-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Adm::t('admparams', 'Create Params'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'value:ntext',
            'updated_at',

            ['class' => '\kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
