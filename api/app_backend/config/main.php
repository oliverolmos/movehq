<?php

$params =  require __DIR__ . '/params.php';

$commonConfig = require(__DIR__ . '/../../common/config/main.php');

$portalConfig = [
    'id' => 'app-app_backend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app_backend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-app_backend',
            'cookieValidationKey' => 'ThKe6KoJ3qfcqJPv3GYIn45T5JbLymO9',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-app_backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used to login
            'name' => 'app_backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

$config = array_merge_recursive($commonConfig, $portalConfig);

return $config;
