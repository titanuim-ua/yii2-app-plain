<?php

$main = require(__DIR__ . '/main.php');

$config = \yii\helpers\ArrayHelper::merge($main, [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ]
]);

return $config;