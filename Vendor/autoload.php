<?php

class Simple {

    public static $classMap;

    public static function autoload($className) {
        if (isset(static::$classMap[$className])) {
            $classFile = static::$classMap[$className];
            include($classFile);
        }
        return;
    }

    public static function createObject($className) {
        return new $className();
    }
}

spl_autoload_register(['Simple','autoload'], true, true);
Simple::$classMap = require __DIR__ . '/classes.php';