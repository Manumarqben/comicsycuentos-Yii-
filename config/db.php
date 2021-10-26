<?php

if (($url = getenv('DATABASE_URL')) !== false) {
    // Configuración para Heroku:
    $config = parse_url($url);
    $host = $config['host'];
    $port = $config['port'];
    $dbname = substr($config['path'], 1);
    $username = $config['user'];
    $password = $config['pass'];
    $extra = [
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
        'on afterOpen' => function ($event) {
            // $event->sender refers to the DB connection
            $event->sender->createCommand("SET intervalstyle = 'iso_8601'")->execute();
        },
    ];
} else {
    // Configuración para entorno local:
    $host = 'ec2-63-33-239-176.eu-west-1.compute.amazonaws.com';
    $port = '5432';
    $dbname = 'dala4p19ngg8su';
    $username = 'zybwagvwdipkqp';
    $password = '3519d3741c07a0bfd9b6a5cd6e494d15301a0322eddcd322f268b0e1c72ed3d2';
    $extra = [];
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => "pgsql:host=$host;port=$port;dbname=$dbname",
    'username' => $username,
    'password' => $password,
    'charset' => 'utf8',
] + $extra;
