<?php

namespace Simple\ServiceProvider;

use Simple\Container;

interface  ServiceProviderInterface {

    public function register($container);
}