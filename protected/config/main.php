<?php

mb_internal_encoding("utf-8");

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'en',
    'sourceLanguage' => 'en',
    'extensions' => yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
        []
    ),
    'modules' =>[

    ],
    'components' => [
        'assetManager' =>[
            'forceCopy'=>YII_DEBUG,
            'bundles' => [
                yii\bootstrap\BootstrapAsset::class => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                yii\bootstrap\BootstrapPluginAsset::class => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
            'converter'=>[
                'class'=>nizsheanez\assetConverter\Converter::class,
                'force'=>false, // true : If you want convert your sass each time without time dependency
                //we do not use directory in our fork
//                'destinationDir' => 'assets/compiled', //at which folder of @webroot put compiled files
                'parsers' => [
                    'sass' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Sass',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'cachePath' => '@app/runtime/cache/sass-parser' // optional options
                        ],
                    ],
                    'scss' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Sass',
                        'output' => 'css', // parsed output file type
                        'options' => [] // optional options
                    ],
                    'less' => [ // file extension to parse
                        'class' => 'nizsheanez\assetConverter\Less',
                        'output' => 'css', // parsed output file type
                        'options' => [
                            'auto' => true, // optional options
                        ]
                    ]
                ]
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
