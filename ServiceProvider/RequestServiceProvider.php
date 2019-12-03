<?php

namespace Simple\ServiceProvider;

use Simple\ServiceProvider\ServiceProviderInterface;
use Simple\Vendor\Request;

class RequestServiceProvider implements ServiceProviderInterface {

    public function register($container)
    {
        $config = $container->get('config')->get('request');
        $container->add("request",new Request($config));

    }

}