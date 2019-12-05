<?php

defined('SIMPLE_PATH') or define('SIMPLE_PATH', __DIR__);
require(__DIR__ . '/../Vendor/autoload.php');
require(__DIR__. '/../Application.php');
$config = require(__DIR__ . '/../config/config.php');
(new Simple\Application($config))->run();