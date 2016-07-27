<?php

mb_internal_encoding("utf-8");

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'en',
    'sourceLanguage' => 'en',
    'timeZone' => 'Europe/Kiev',
    'extensions' => yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
        []
    ),
    'modules' =>[

    ],
    'components' => [
        'assetManager' => [
            'forceCopy' => YII_DEBUG,
            'converter' => [
                'class' => app\components\postcss\Converter::class,
                'force' => false,
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
//            'class' => 'yii\caching\MemCache',
//            'keyPrefix' => 'PLAIN.',
//            'servers' => [
//                [
//                    'host' => '127.0.0.1',
//                    'port' => 11211,
//                    'weight' => 1024,
//                ],
//            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host'    => 'halk.min.org.ua',
                'username'=> 'bot@',
                'password'=> '',
                'port'    => '25',
            ],
            'messageConfig'=>[
                'from'     => array('bot@' => ''),
                'bcc'     => array('copy@' => ''),
                'replyTo'     => array('ask@' => 'Support'),
            ]
        ],
        'urlManager' => include(__DIR__ . "/include/url.php"),
        'log' => include(__DIR__ . "/include/log.php"),
    ],
    'params' => require(__DIR__ . '/include/params.php'),
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
