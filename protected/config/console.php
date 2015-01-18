<?php

$main = require(__DIR__ . '/main.php');
unset($main["components"]["errorHandler"]);
unset($main["components"]["user"]);
unset($main["components"]["request"]);

$config = \yii\helpers\ArrayHelper::merge($main, [
    'controllerNamespace' => 'app\commands',
    'components' => [
        'urlManager'=>
        [
            'baseUrl' => 'http://yii2-app-plain.com/',
        ],
    ]
]);

return $config;
