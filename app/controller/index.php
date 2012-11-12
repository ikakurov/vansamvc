<?php

namespace app\controller;

class Index extends \system\core\Controller {

    public function __construct() {
        parent::__constructor();
    }

    public function index() {
        $data['title'] = 'title';
      $this->load->view('index',$data);
    }

}