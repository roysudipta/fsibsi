<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Teams extends FB_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('team_model');
    }

    public $tblTeams = 'participant_team';

    function listTeams() {
        $data['teams'] = $this->team_model->listTeams();

        $this->_AdminView(PAGE_ADMIN_TEAMS, $data);
    }

    function getDetails($id) {

        $data['query'] = $this->team_model->details_team($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => 'Success', 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No team data found against this record!', 'data' => array()));
        }
    }

}
