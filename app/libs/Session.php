<?php
namespace app\libs;
class Session {
        private function __construct() {
            ;
        }
        public static function start(){
            if(!isset($_SESSION)){
                session_start();
            }
        }
        public static function set($name, $value) {
            if(!empty($name)&&!empty($value)){
                $_SESSION[$name]=$value;
            }
        }
        public static function get($name) {
            if(isset($_SESSION[$name])){
                return $_SESSION[$name];
            };
        }
        public static function destroy(){
            if(isset($_SESSION)){
                unset($_SESSION);
                session_unset();
                session_destroy();
            }
        } 
}

?>
