Yii2: Adm-Params Модуль для Adm CMS
================

Установка
------------
Удобнее всего установить это расширение через [composer](http://getcomposer.org/download/).

```
   "pavlinter/yii2-adm-params": "*",
```

Настройка
-------------
```php
'on beforeRequest' => function ($event) {
    $params = \pavlinter\admparams\models\Params::bootstrap();
    Yii::$app->params = \yii\helpers\ArrayHelper::merge(Yii::$app->params, $params);
},
'modules' => [
    ...
    'adm' => [
        ...
        'modules' => [
            'admparams'
        ],
        ...
    ],
    'admparams' => [
        'class' => 'pavlinter\admparams\Module',
    ],
    ...
],
```

Запустить миграцию
-------------
```php
yii migrate --migrationPath=@vendor/pavlinter/yii2-adm-params/admparams/migrations
```