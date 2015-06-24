<?php

$params = require(__DIR__ . '/params.php');
$components = require(__DIR__ . '/components.php');
$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'Yii2 Home',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => $components,
    'params' => $params,
    'modules' => $modules,
    'language' => 'ru',
    'sourceLanguage' => 'en',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
