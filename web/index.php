<?php

$env = getenv('YII_ENV') ?: 'dev';
defined('YII_ENV') or define('YII_ENV', $env);

defined('YII_DEBUG') or define('YII_DEBUG', YII_ENV === 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
