<?php

namespace system\core;

class Loader {

    public function __constructor() {
        
    }

final   public function __call($name, $arguments) {
        $namespace = "app" . "\\" . strtolower($name);
        $class = array_shift(ucfirst(strtolower($arguments)));
        $includeClass = $namespace . "\\" . $class;
        $registry = Registry::getInstance();
        if (isset($arguments)) {

            $registry->$class = new $includeClass($arguments);
        } else {
            return $registry->$class = new $includeClass();
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
            throw new \Exception('Файла '.$file." не е намерен");
        }
        if (isset($view)) {
            return $view;
            ob_clean();
        }
    }

}