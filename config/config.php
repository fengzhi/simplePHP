<?php

$config = [

    "name" => "simple",
    "services" => [
        \Simple\ServiceProvider\RequestServiceProvider::class,
        \Simple\ServiceProvider\ResponseServiceProvider::class,
        \Simple\ServiceProvider\MysqlServiceProvider::class
    ],
    'request' => [],
    'response' => [],
    'db' => [
        'database_type' => 'mysql',
        'dsn' => 'mysql:host=127.0.0.1:3306;dbname=user',
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ]
];

return $config;
