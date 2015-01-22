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

```