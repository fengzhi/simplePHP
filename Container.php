<?php

/**
 * @author    xiaoyunfeng
 * @copyright 2019
 *
 */

namespace Simple;

/**
 *  Class Container
 */
Class Container {

    /**
     * @var $containers
     */
    protected $containers;

    /**
     * @param $name
     * @param $object
     */
    public function add($name,$object) {
        $this->containers[$name] = $object;
    }

    /**
     * @param $name
     * @return object | bool
     */
    public function get($name) {
        if(isset($this->containers[$name])) {
            return $this->containers[$name];
        }else{
            return false;
        }
    }

}
