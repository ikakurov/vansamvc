<?php

namespace system\core;

/**
 * SplClassLoader implementation that implements the technical interoperability
 * standards for PHP 5.3 namespaces and class names.
 *
 * http://groups.google.com/group/php-standards/web/final-proposal
 *
 *     // Example which loads classes for the Doctrine Common package in the
 *     // Doctrine\Common namespace.
 *     $classLoader = new SplClassLoader('Doctrine\Common', '/path/to/doctrine');
 *     $classLoader->register();
 *
 * @author Jonathan H. Wage <jonwage@gmail.com>
 * @author Roman S. Borschel <roman@code-factory.org>
 * @author Matthew Weier O'Phinney <matthew@zend.com>
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 * @author Fabien Potencier <fabien.potencier@symfony-project.org>
 */
class AutoLoader {

    private $_fileExtension = '.php';
    private $_namespace;
    private $_includePath;
    private $_namespaceSeparator = '\\';
    private $_map = array();

    /**
     * [addClasses description]
     * Caches classes
     * @param [array] $classes [add auto load classess]
     */
    public function addClasses($classes) {
        if (is_array($classes)) {
            $this->_map = array_merge($this->_map, $classes);
            return true;
        }
        return flase;
    }

    public function addClass($namespace, $path) {
        if ($namespace and $path) {
            if (!isset($this->_map[$namespace])) {
                $this->_map[$namespace] = $path;
                return true;
            }
        }
        return false;
    }

    /**
     * Sets the namespace separator used by classes in the namespace of this class loader.
     *
     * @param string $sep The separator to use.
     */
    public function setNamespaceSeparator($sep) {
        $this->_namespaceSeparator = $sep;
    }

    /**
     * Gets the namespace seperator used by classes in the namespace of this class loader.
     *
     * @return void
     */
    public function getNamespaceSeparator() {
        return $this->_namespaceSeparator;
    }

    /**
     * Sets the base include path for all class files in the namespace of this class loader.
     *
     * @param string $includePath
     */
    public function setIncludePath($includePath) {
        $this->_includePath = $includePath;
    }

    /**
     * Gets the base include path for all class files in the namespace of this class loader.
     *
     * @return string $includePath
     */
    public function getIncludePath() {
        return $this->_includePath;
    }

    /**
     * Sets the file extension of class files in the namespace of this class loader.
     *
     * @param string $fileExtension
     */
    public function setFileExtension($fileExtension) {
        $this->_fileExtension = $fileExtension;
    }

    /**
     * Gets the file extension of class files in the namespace of this class loader.
     *
     * @return string $fileExtension
     */
    public function getFileExtension() {
        return $this->_fileExtension;
    }

    /**
     * Installs this class loader on the SPL autoload stack.
     */
    public function register() {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Uninstalls this class loader from the SPL autoloader stack.
     */
    public function unregister() {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Loads the given class or interface.
     *
     * @param string $className The name of the class to load.
     * @return void
     */
    public function loadClass($className) {
        if (null === $this->_namespace || $this->_namespace . $this->_namespaceSeparator === substr($className, 0, strlen($this->_namespace . $this->_namespaceSeparator))) {
            $fileName = '';
            $namespace = '';
            if (false !== ($lastNsPos = strripos($className, $this->_namespaceSeparator))) {
                $namespace = substr($className, 0, $lastNsPos);
                $className = substr($className, $lastNsPos + 1);
                $fileName = str_replace($this->_namespaceSeparator, DS, $namespace) . DS;
            }
            if (!empty($namespace)) {
                $newNamespace = $namespace . "\\" . $className;
                if (isset($this->_map[$newNamespace])) {
                    $path = $this->_map[$newNamespace];

                    if (file_exists($path)) {
                        include $path;
                        return true;
                    }
                }
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