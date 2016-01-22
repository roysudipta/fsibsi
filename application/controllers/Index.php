<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends FB_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->_FrontView(PAGE_FRONT_HOME);
    }

}
