<?php

class Simple {

    public static $classMap;

    /**
     * autoload
     * @param $className
     */
    public static function autoload($className) {
        if (isset(static::$classMap[$className])) {
            $classFile = static::$classMap[$className];
        }else{
            $simplePath = str_replace("Simple", SIMPLE_PATH."/..", $className);
            $classFile = str_replace('\\', '/', $simplePath) . '.php';
        }
        include($classFile);
        return;
    }

    public static function createObject($className) {
        return new $className();
    }
}

spl_autoload_register(['Simple','autoload'], true, true);
Simple::$classMap = require __DIR__ . '/classes.php';