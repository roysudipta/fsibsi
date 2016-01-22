<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends FB_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('event_model');
    }

    public $tblUsers = 'users';

    function admins() {
        $data['users'] = $this->user_model->listUsers(array('where' => array($this->tblUsers . '.is_type' => CONST_USER_ADMIN)));
        $data['user_types'] = $this->user_model->listUserType();
        $data['events'] = $this->event_model->listEvents();
        $this->_AdminView(PAGE_ADMIN_USERS_ADMIN, $data);
    }

    function officials() {
        $data['users'] = $this->user_model->listUsers(array('where' => array($this->tblUsers . '.is_type' => CONST_USER_OFFICIAL)));
        $data['user_types'] = $this->user_model->listUserType();
        $data['events'] = $this->event_model->listEvents();
        $this->_AdminView(PAGE_ADMIN_USERS_OFFICIAL, $data);
    }

    function teams() {
        $data['users'] = $this->user_model->listUsers(array('where' => $this->tblUsers . ".is_type NOT IN ('" . CONST_USER_ADMIN . "','" . CONST_USER_OFFICIAL . "')"));

        $this->_AdminView(PAGE_ADMIN_USERS_TEAM, $data);
    }

    function getDetails($id) {

        $data['query'] = $this->user_model->getUser($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => 'Success', 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No user data found against this record!', 'data' => array()));
        }
    }

    function saveDetails($id) {

        $id = $this->input->post('user_id');

        if ($id != '') {
            $user = $this->user_model->getUser($id);
            if (!empty($user)) {
                if ($user['user_email_id'] == $this->input->post('user_email_id')) {
                    $data = array('user_name' => $this->input->post('user_name'));
                } else {
                    $data = array('user_name' => $this->input->post('user_name'),
                        'user_email_id' => $this->input->post('user_email_id'),
                        'is_verified' => CONST_DEACTIVATE,
                        'is_status' => CONST_DEACTIVATE);
                }
            }
            $data['query'] = $this->user_model->Update($data, $id);
            /*
             * Sending Mail If email ID Changed
             */
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
            $this->user_model->delete($id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    function changeStatus($id, $status) {

        $data['query'] = $this->user_model->changeStatus($id, $status);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => $this->lang->line(MSG_SCS_UPDATE_SUCCESS), 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
        }
    }

}
