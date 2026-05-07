<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON, 
            'charset' => 'UTF-8',
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', 
            ],
            'cookieValidationKey' => 'BMWYGg4_edSGUWl_6WFl9pXcUIYkrCiw',
        ],
        'jwt' => [
            'class' => \bizley\jwt\Jwt::class,
            'signer' => \bizley\jwt\Jwt::HS256,
            'signingKey' => getenv('JWT_SECRET') ?: 'chave-secreta-local-apenas-para-dev',
            'verifyingKey' => getenv('JWT_SECRET') ?: 'chave-secreta-local-apenas-para-dev',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
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
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => ['pedido', 'produto', 'unidade', 'pedido-item', 'pagamento-mock']],
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV && class_exists('yii\debug\Module')) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // 'allowedIPs' => ['127.0.0.1', '::1'], // ajuste opcional
    ];
}

if (YII_ENV_DEV && class_exists('yii\gii\Module')) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // 'allowedIPs' => ['127.0.0.1', '::1'], // ajuste opcional
    ];
}

return $config;
