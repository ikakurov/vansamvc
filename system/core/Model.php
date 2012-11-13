<?php
namespace system\core;
class Model extends \PDO {
  
    /**
     * @return object PDO
     */
  public function __construct($file = 'my_setting.ini') {
        include SYSTEM . DS . "config" . DS . "db_conn.php";
        $dsn = 'mysql:host='.$conf['db']['host'].';dbname='.$conf['db']['dbname'].'';
        parent::__construct($dsn, $conf['db']['user'],$conf['db']['pass']);
    }

}

?>
