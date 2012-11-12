<?php

namespace system\core;

/**
 *
 */
abstract class Controller {

    protected $load,
            $registry;

    function __constructor() {
        $this->load = new Loader();
        $this->registry = Registry::getInstance();
    }

    abstract function index();

    final public function __get($name) {
        if ($retunr = $this->registry->$name) {
            return $retunr;
        }
    }

}