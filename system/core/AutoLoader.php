<?php

namespace system\core;

class AutoLoader {

    private $_fileExtension = '.php';
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = '\\';

    public function __construct($ns = null, $includePath = null) {
        $this->_namespace = $ns;
        $this->_includePath = $includePath;
    }

 
    public function setNamespaceSeparator($sep) {
        $this->_namespaceSeparator = $sep;
    }

    public function getNamespaceSeparator() {
        return $this->_namespaceSeparator;
    }

   
    public function setIncludePath($includePath) {
        $this->_includePath = $includePath;
    }

   
    public function getIncludePath() {
        return $this->_includePath;
    }

    
    public function setFileExtension($fileExtension) {
        $this->_fileExtension = $fileExtension;
    }

    public function getFileExtension() {
        return $this->_fileExtension;
    }
    public function register() {
        spl_autoload_register(array($this, 'loadClass'));
    }
    public function unregister() {
        spl_autoload_unregister(array($this, 'loadClass'));
    }
    public function loadClass($className) {
        if (null === $this->_namespace || $this->_namespace . $this->_namespaceSeparator === substr($className, 0, strlen($this->_namespace . $this->_namespaceSeparator))) {
            $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($className, $this->_namespaceSeparator))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace($this->_namespaceSeparator, DS, $namespace) . DS;
            }
            $fileName .= str_replace('_', DS, $className) . $this->_fileExtension;

            if (file_exists($fileName)) {
                require ($this->_includePath !== null ? $this->_includePath . DS : '') . $fileName;
            } else {
                throw new \Exception("Не е намерен файла " . $fileName);
            }
        }
    }

}