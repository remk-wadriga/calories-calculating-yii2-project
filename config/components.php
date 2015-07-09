<?php

$routes = require(__DIR__ . '/routes.php');
$db = require(__DIR__ . '/db.php');

return [
    'request' => [
        // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
        'cookieValidationKey' => 'YWsdfdf8XNs-vUgfgrAuwJsdfhs4JhfddrOZ',
    ],
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
    'user' => [
        'class' => 'app\components\User',
        'identityClass' => 'app\models\User',
        'enableAutoLogin' => true,
    ],
    'errorHandler' => [
        'errorAction' => 'index/error',
    ],
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        // send all mails to a file by default. You have to set
        // 'useFileTransport' to false and configure a transport
        // for the mailer to send real emails.
        'useFileTransport' => true,
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
    'db' => $db,
    'urlManager' => [
        'class' => 'app\components\UrlManager',
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => $routes,
        'enableStrictParsing' => true,
    ],
    'view' => [
        'class' => 'app\components\View',
    ],
    'timeService' => [
        'class' => 'app\components\TimeService',
    ],
    'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\PhpMessageSource',
            ],
        ],
    ],
    'statsService' => [
        'class' => 'app\components\StatsService',
    ],
    'amqpService' => [
        'class' => 'app\components\AmqpService',
        'timeOut' => 60,
    ],
];