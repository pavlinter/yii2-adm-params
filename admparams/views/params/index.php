<?php

use pavlinter\admparams\Module;
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

    <p>
        <?= Html::a(Adm::t('admparams', 'Create Params'), ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= Adm::widget('GridView',[
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'vAlign' => 'middle',
            ],
            [
                'attribute' => 'value',
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return \yii\helpers\StringHelper::truncate($model->value, 70);
                },
            ],
            [
                'attribute' => 'description',
                'vAlign' => 'middle',
                'format' => 'raw',
                'value' => function ($model) {
                    return Module::t('description', $model->name,['dot' => true]);
                },
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'options' => [
                    'style' => 'width:70px;',
                ],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if ($model->isSerialized()) {
                            return null;
                        }
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                            'title' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>
