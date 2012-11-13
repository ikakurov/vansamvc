<?php

namespace system\core;

/**
 *
 */
abstract class Controller {

    protected $load, $registry;

    public function __constructor() {
        $this->registry = Registry::getInstance();  
        $this->load  = new Load();
        
    }

    abstract function index();

    final public function __get($name) {     
        if ($return = $this->registry->$name) {
            return $return;
        }
    }

}