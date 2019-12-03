<?php

namespace Simple\ServiceProvider;

use Simple\Container;
use Simple\Vendor\Response;

Class ResponseServiceProvider implements ServiceProviderInterface {


    public function register($container)
    {
        $config = $container->get('config')->get('response');
        $container->add("response",new Response($config));
    }
}