<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('User_model');
    }

    public
            function index() {
        $this->load->view('welcome_message');
    }

}
