<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => getenv('DB_DSN') ?: 'pgsql:host=localhost;port=5432;dbname=raizes_nordeste',
    'username' => getenv('DB_USER') ?: 'postgres',
    'password' => getenv('DB_PASS') ?: '3636',
    'charset' => 'utf8',
];