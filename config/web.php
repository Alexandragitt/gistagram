<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'ru',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'aCXmnua76rxuM0j0cOpRlgjt6iUaRKXU',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'loginUrl' => ['auth/login'],
            
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'formatter' => [
               'defaultTimeZone' => 'Europe/Kiev',
               'dateFormat' => 'd MMMM yyyy',
               'datetimeFormat' => 'd-M-Y H:i:s',
               'timeFormat' => 'H:i:s', 
       ],
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
        'db' => require(__DIR__ . '/db.php'),
       
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<id:\d+>' => 'profile/index',
                '/profile/subscribe/<id:\d+>' => 'profile/subscribe',
                '/profile/unsubscribe/<id:\d+>' => 'profile/unsubscribe',
                '/feed' => 'feed/index',
                '/profile/view/<id:\d+>' => 'profile/view',
                '/liked' => 'profile/liked',
                '/blocked' => 'profile/blocked',
            ], 
        ],
        
    ],
    'modules' => [
        'admin' => [
            'defaultRoute' => '/user/',
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'params' => $params,
    'defaultRoute' => '/profile/index',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
