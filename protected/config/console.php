<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

return \yii\helpers\ArrayHelper::merge(require('config.php'),[
    'id' => 'basic-console',
    'controllerNamespace' => 'app\commands',
    'bootstrap' => ['ubi','forum'],
    'components' => [
        'urlManager' => [
            'baseUrl' => "https://auto.today",
        ],
    ],
]);
