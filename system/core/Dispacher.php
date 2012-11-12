<?php

namespace system\core;

class Dispacher {

    protected $_parts;
    private $namespace = "app\\controller", $_controller, $_method, $_args;
    private static $_classes = array();

    public function __construct() {
        $this->setSegments()->route();
    }

    /**
     * Reduce URL to controller componetns
     * Add namespase and create aoutoloader use him
     * @var type['strin'] $namespace
     * @var type['string'] $_contoroller
     * @var type['string'] $_method
     * @var type['string'] $_args
     *
     * @var type['string'] $_parts
     *
     * @return \system\core\Dispacher
     */
    protected function setSegments() {
        $this->_parts = array_merge(array_filter(explode("/", $_SERVER['REQUEST_URI'])));
        //Check for folder or subfolder
        //This is recursive to class methotd
        if (isset($this->_parts[0])) {
            if ($this->isDir(@$this->_parts[0])) {
                while (false !== $this->isDir(@$this->_parts[0])) {
                    if ($this->isDir($this->_parts[0])) {
                        //If find dir or sub din in contrller folders add him to namespace like namespace suffix
                        $this->namespace = $this->namespace . "\\" . array_shift($this->_parts);
                    }
                }
            }
            $this->_controller = $this->namespace . "\\" . array_shift($this->_parts);
        } else {
            $this->_controller = $this->namespace . "\\" . BaseController;
        }
        if (isset($this->_parts[0])) {
            $this->_method = array_shift($this->_parts);
        } else {
            $this->_method = "index";
        }
        if (isset($this->_parts[0])) {
            $this->_args = $this->_parts;
        }
        return $this;
    }

    /**
     * Route elements of url
     * Like controlers methods and arguments
     * @todo  Validations on paraps
     * @throws \Exception
     */
    public function route() {
        if (!isset(self::$_classes[$this->_controller])) {
            self::$_classes[$this->_controller] = new $this->_controller;
            if (method_exists(self::$_classes[$this->_controller], $this->_method)) {
                $scope = new \ReflectionMethod($this->_controller, $this->_method);
                if ($scope->isPublic()) {
                    if (!isset($this->_args)) {
                        call_user_func(array(self::$_classes[$this->_controller], $this->_method));
                    } else {
                        call_user_func_array(array(self::$_classes[$this->_controller], $this->_method), $this->_args);
                    }
                } else {
                    throw new \Exception('Тази страница е забранена');
                }
            } else {
                throw new \Exception('Няма Такава страница');
            }
        }
    }

    /**
     * @discription Check for folder in root class folder
     * @param type[string] $folder
     * @return boolean
     */
    private function isDir($folder) {
        $dir = str_replace('\\', "/", $this->namespace) . DS . $folder;
        if (is_dir($dir)) {
            return true;
        } else {
            return false;
        }
    }

}