<?php

return \yii\helpers\ArrayHelper::merge(require('config.php'),[

    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'al;fkj0mj8h9re8br',
        ],
        'errorHandler' => [
            'class' => \yii\web\ErrorHandler::class,
            'errorAction' => 'site/error',
        ],
        'user' => [
            'loginUrl' => ['user/login'],
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
    ],

]);
