<?php

namespace Simple\ServiceProvider;

class MysqlServiceProvider implements ServiceProviderInterface {

    public function register($container)
    {
        $config = $container->get('config')->get('db');
        $container->add("db",new \Simple\Vendor\Database($config));
    }
}