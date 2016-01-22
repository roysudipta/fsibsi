<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('event_model');
    }

    public function index() {
        $data['events'] = $this->event_model->listEvents();
        $this->_AdminView(PAGE_ADMIN_EVENTS, $data);
    }

    public function getDetails($id) {

        $data['query'] = $this->event_model->getEvent($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => array(), 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
        }
    }

    public function saveDetails() {
        if ($this->input->post()) {
            $id = $this->input->post('event_id');

            $data = array('event_name' => $this->input->post('event_name'),
                'date_start' => $this->input->post('event_name'),
                'date_end' => $this->input->post('event_name'),
                'is_ongoing' => $this->input->post('event_name'));

            if ($id != '') {
                $id = $this->event_model->add($data);
            } else {
                $this->event_model->update($data, $id);
            }
            if (!empty($data['query'])) {
                echo json_encode(array('success' => true, 'message' => array(), 'data' => $data['query']));
            } else {
                echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
            }
        }
    }

    public function deleteDetails() {
        
    }

}
