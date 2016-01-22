<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Colleges extends FB_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('college_model');
    }

    public $tblColleges = 'colleges';

    function listColleges() {
        $data['colleges'] = $this->college_model->listColleges();

        $this->_AdminView(PAGE_ADMIN_COLLEGES, $data);
    }

    function getDetails($id) {

        $data['query'] = $this->college_model->getCollege($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => 'Success', 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
        }
    }

    function collegeDetails() {

        $id = $this->input->post('college_id');

        $data = array('college_name' => $this->input->post('college_name'), 'address' => $this->input->post('address'));

        if ($id != '') {
            $data['query'] = $this->college_model->Update($data, $id);
            if ($data['query']) {
                echo json_encode(array('success' => true, 'message' => $this->lang->line(MSG_SCS_SAVE_SUCCESS), 'data' => $data['query']));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_SAVE_FAIL), 'data' => array()));
            }
        } else {
            $data['query'] = $this->college_model->add($data);
            if (!empty($data['query'])) {
                echo json_encode(array('success' => true, 'message' => $this->lang->line(MSG_SCS_UPDATE_SUCCESS), 'data' => $data['query']));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_UPDATE_FAIL), 'data' => array()));
            }
        }
    }

    function deleteDetails($id) {
        if ($id !== '') {
            $this->college_model->delete($id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

}
