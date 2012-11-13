<?php

namespace app\model;

class Articles extends \system\core\Model {

    public function __construct() {
      
        parent::__construct();
    }
    public function test(){
          echo "Бачка Модела .".__CLASS__;
    }

}

?>
