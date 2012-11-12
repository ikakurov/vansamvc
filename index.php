<?php

//Show error
error_reporting(E_ALL);

try {

    /**
     * @todo CREATE PREMMISION STRUCTURE AND CRUD OR DATE MAPPER CLASS
     * @todo RENDER THE VIEW AND CECHE AND BUFFERNING 
     * DEFINE HTTP CONSTANTS
     */
    if (!function_exists('bootstrapLoader')) {

        function bootstrapLoader() {
            defined("DS") or define("DS", DIRECTORY_SEPARATOR);
            defined("ROOT") or define("ROOT", realpath(dirname(__FILE__)));
            include ROOT . DS . 'system' . DS . "config" . DS . 'constants.php';
            include CORE . DS . "AutoLoader.php";
            include SYSTEM . DS . "config" . DS . "constants.php";
         

            $autoloader = new system\core\AutoLoader();
            $autoloader->register();
            new \system\core\Dispacher();
        }

    }
    bootstrapLoader();
}  catch (PDOException $e){
    echo $e->getMessage();
} 
catch (Exception $e) {
    echo $e->getMessage();
}