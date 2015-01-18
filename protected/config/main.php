<?php

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions' => yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
        []
    ),
    'components' => [
        'assetManager' =>[
            'converter'=>[
                'class'=>'nizsheanez\assetConverter\Converter',
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
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'xxxxxxx',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
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
