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
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
    ],
    'components' => [
        'assetManager' => [
            'forceCopy' => YII_DEBUG,
            'converter' => [
                'class' => tit\utils\postcss\Converter::class,
                'force' => false,
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'PLAIN.'.(file_exists(__DIR__."/cache.key") ? trim(file_get_contents(__DIR__."/cache.key")): ''),
//            'class' => 'yii\caching\MemCache',
//            'servers' => [
//                [
//                    'host' => '127.0.0.1',
//                    'port' => 11211,
//                    'weight' => 1024,
//                ],
//            ],
//            'class' => yii\redis\Cache::class,
//            'redis' => 'redis'
        ],

//        'redis'=>[
//            'class'=>yii\redis\Connection::class,
//            'hostname' => '127.0.0.1',
//            'port' => 6379,
//            'database' => 1,
//        ],

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
