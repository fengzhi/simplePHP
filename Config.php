<?php

/**
 * @author    xiaoyunfeng
 * @copyright 2019
 *
 */

namespace Simple;

/**
 *  Class Config
 */
class Config {

    public $config;

    public function __construct($config) {
        $this->config = $config;
    }

    public function get($name) {
        if(isset($this->config[$name])) {
            return $this->config[$name];
        }else{
            return null;
        }
    }

}