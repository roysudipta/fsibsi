<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends FB_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->_AdminView(PAGE_ADMIN_DASHBOARD_STATS);
    }

}
