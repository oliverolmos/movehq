<?php

$globalConf = json_decode(file_get_contents(__DIR__.'/../../../global_conf.json'));

return [
	'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
			'cachePath' => '@common/runtime/cache'
        ],
    	'db' => [
    		'class' => 'yii\db\Connection',
    		'dsn' => $globalConf->database->dsn,
    		'username' => $globalConf->database->username,
    		'password' => $globalConf->database->password,
    		'charset' => 'utf8',
			'enableSchemaCache' => true,
			'schemaCacheDuration' => 1440,
			'schemaCache' => 'cache',
    	],
    	'jwt' => [
    		'class' => 'sizeg\jwt\Jwt',
    		'key'   => 'secret',
    	],
    	'urlManager' => [
    		'class' => 'yii\web\UrlManager',
    		// Disable index.php
    		'showScriptName' => false,
    		// Disable r= routes
    		'enablePrettyUrl' => true,
    		'rules' => array(
    			'<controller:\w+>/<id:\d+>' => '<controller>/view',
    			'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
    			'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    		),
    	],
    ],
	'params' => [
		'backendUrl' => $globalConf->backend_url,
		'frontendUrl' => $globalConf->frontend_url,
		'user.passwordResetTokenExpire' => $globalConf->user_password_reset_token_expiration,
		'auth_token' => $globalConf->auth_token,
	],
];

