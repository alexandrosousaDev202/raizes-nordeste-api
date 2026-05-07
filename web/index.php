<?php

// 1. FORÇAR EXIBIÇÃO DE ERROS NO LOG (TEMPORÁRIO)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

// Carregamento seguro do .env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

// Lê o ambiente do Render
$env = getenv('YII_ENV') ?: 'dev';
defined('YII_ENV') or define('YII_ENV', $env);
defined('YII_DEBUG') or define('YII_DEBUG', true); // Forçamos debug true para ver o erro real

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();