<?php

defined('BASEPATH') OR exit('No direct script access allowed');


/*
 * A COMMON CLASS EXTENDING MAIN CONTROLLER.
 */

class FB_Controller extends CI_Controller {

    protected $CI;
    public $session_variable = null;

    function __construct() {

        parent:: __construct();

        date_default_timezone_set("Asia/Calcutta");
        $this->session_variable = $this->session->userdata('session_user');
    }

    public function _AdminView($view, $data = null) {
        if ($this->session_variable['is_type'] == CONST_USER_ADMIN) {


            $this->load->view(PAGE_ADMIN_HEADER_META);
            $this->load->view(PAGE_ADMIN_HEADER_ASSETS);
            $this->load->view(PAGE_ADMIN_BODY_TOP_BAR);
            $this->load->view(PAGE_ADMIN_BODY_MENU);
            $this->load->view(PAGE_ADMIN_SCRIPT);

            $data['content']['page_content'] = $this->load->view($view, $data, TRUE);

            $this->load->view(PAGE_ADMIN_BODY_MAIN, $data);
            $this->load->view(PAGE_ADMIN_FOOTER);
        } else {
            $this->load->view(PAGE_RESCRICTED);
        }
    }

    public function _FrontView($view, $data = null) {
//        if (!empty($this->session_variable)) {
//            if ($this->session_variable['is_type'] == CONST_USER_CAPTAIN || $this->session_variable['is_type'] == CONST_USER_FACULTY ||
//                    $this->session_variable['is_type'] == CONST_USER_TEAMMEMBER || $this->session_variable['is_type'] == CONST_USER_VICECAPTAIN) {

                $data['content'] = $this->load->view($view, $data, TRUE);

                $this->load->view(PAGE_FRONT_HEAD);
                if (empty($this->uri->segment_array())) {
                    $this->load->view(PAGE_FRONT_HEADER);
                }
                $this->load->view(PAGE_FRONT_HEADER_MENU);
                $this->load->view(PAGE_FRONT_COMMON_SCRIPTS);

                $this->load->view(PAGE_FRONT_BODY_MAIN, $data);
                $this->load->view(PAGE_FRONT_SCRIPT);
                $this->load->view(PAGE_FRONT_FOOTER);
//            } else {
//                $this->load->view(PAGE_RESCRICTED);
//            }
//        } else {
//            $data['content'] = $this->load->view($view, $data, TRUE);
//
//            $this->load->view(PAGE_FRONT_HEAD);
//            if (empty($this->uri->segment_array())) {
//                $this->load->view(PAGE_FRONT_HEADER);
//            }
//            $this->load->view(PAGE_FRONT_HEADER_MENU);
//            $this->load->view(PAGE_FRONT_COMMON_SCRIPTS);
//
//            $this->load->view(PAGE_FRONT_BODY_MAIN, $data);
//            $this->load->view(PAGE_FRONT_SCRIPT);
//            $this->load->view(PAGE_FRONT_FOOTER);
//        }
    }

    public function convertTitletoSlugAlias($string) {
        $slug = strtolower($string);
        $slug = html_entity_decode($slug);
        $slug = str_replace('.', '-', $slug);
        $slug = str_replace(array('', '', '', ''), array('ae', 'ue', 'oe', 'ss'), $slug);
        $slug = preg_replace('~[^\\pL\d.]+~u', '-', $slug);
        $slug = preg_replace('#[\s]{2,}#', ' ', $slug);
        $slug = str_replace(array(' '), array('-'), $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

}

/* Location: ./application/libraries/FB_Controller.php */

