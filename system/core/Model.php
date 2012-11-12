<?php
namespace system\core;

class Model {
    public function __construct() {
           include SYSTEM . DS . "config" . DS . "db_conn.php";
        echo "<pre>".print_r($db, 1)."</pre>";;
    }
    
}

?>
