<?php

$config = [

    "name" => "simple",
    "services" => [
        \Simple\ServiceProvider\RequestServiceProvider::class,
        \Simple\ServiceProvider\ResponseServiceProvider::class
    ]
];

return $config;
