<?php

namespace app\model;

class Articles extends \system\core\Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
       $sth= $this->prepare("SELECT * FROM `customers` WHERE `country` = 'USA' ");
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

}

?>
