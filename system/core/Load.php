<?php

namespace system\core;

class Load {

    public function __constructor() {
        
    }

    final public function __call($name, $arguments) {
        $namespace = "app" . "\\" . strtolower($name);
        $class = ucfirst(strtolower(array_shift($arguments)));
        $includeClass = $namespace . "\\" . $class;
        $registry = Registry::getInstance();
        //Check properties of a constructor
        if (isset($arguments)) {
            $registry->$class = new $includeClass($arguments);
           
        } else {
             $registry->$class = new $includeClass();
        }
    }

    final public function view($name, $data = NULL, $ext = ".php") {
        $file = VIEW . DS . $name . $ext;
        if (file_exists($file)) {
            ob_start();
            if (isset($data)) {
                extract($data);
                unset($data);
            }
            include $file;
            $view = ob_get_contents();
        } else {
            throw new \Exception('Файла ' . $file . " не е намерен");
        }
        if (isset($view)) {
            return $view;
            ob_end_flush();
            exit;
        }
    }

}