<?php

namespace system\core;

class Registry {

    private static $_instantie;
    public $_args;

    private function __construct() {
        
    }


    public static function getInstance() {
        if (!self::$_instantie instanceof self) {
            self::$_instantie = new Registry();
        }
        return self::$_instantie;
    }

    public final function __get($name) {

        if (isset($this->_args[$name])) {
            return $this->_args[$name];
        }
        throw new \Exception("The method __get/__set is broken in registry <hr/> ");
    }
    public final function __set($name, $value) {
        $this->_args[$name] = $value;
    }

}
