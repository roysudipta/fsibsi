<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblSecurityQuestion = 'security_q';
    public $tblUsers = 'users';
    public $tblCountry = 'country';
    public $tblState = 'state';
    public $tblCity = 'city';
    public $tblEvents = 'events';
    public $tblTeam = 'participant_team';
    public $tblCarno = 'car_no';
    public $tblUserType = 'user_type';
    public $tblCollege = 'participant_college';

    public function ListQuestion() {

        $query = $this->db->get($this->tblSecurityQuestion);
        return $query->result();
    }

    public function authenticate($uid, $pwd) {
       // echo $uid.'~'.$pwd;die;
        $where = array('user_email_id' => $uid, 'user_pwd' => do_hash($pwd, 'md5'));
        $query = $this->db->get_where($this->tblUsers, $where);
        //return $this->db->last_query();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        }
    }

    public function listUsers($param = array()) {
        if (array_key_exists('select', $param)) {
            $this->db->select($param['select']);
        }
        if (array_key_exists('where', $param)) {
            $this->db->where($param['where']);
        }
        if (array_key_exists('join', $param)) {
            $this->db->join($param['join']);
        }

        $query = $this->db->get($this->tblUsers);

        return $query->result_array();
    }

    public function getUser($id) {
        $query = $this->db->select(array($this->tblUsers . '.*'))
                ->get_where($this->tblUsers, array($this->tblUsers . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function updateUser($data, $id) {
        $this->db->update($this->tblUsers, $data, array('id' => $id));
        #echo $this->db->last_query();exit;
    }

    public function addUser($data) {
        $this->db->insert($this->tblUsers, $data);
        return $this->db->insert_id();
    }

    public function changeStatus($id, $status) {
        $this->db->update($this->tblUsers, array('is_status' => $status), array('id' => $id));

        $query = $this->db->select(array($this->tblUsers . '.is_status'))->get_where($this->tblUsers, array($this->tblUsers . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function listCountry() {

        $query = $this->db->get($this->tblCountry);

        return $query->result_array();
    }

    public function listState($country_id) {

        $query = $this->db->get_where($this->tblState, array('state_country_id' => $country_id));

        return $query->result_array();
    }

    public function listCity($state_id) {

        $query = $this->db->get_where($this->tblCity, array('city_state_id' => $state_id));

        return $query->result_array();
    }

    public function ListEvent() {
        $query = $this->db->get($this->tblEvents);

        return $query->result_array();
    }

    public function listUserType() {
        $query = $this->db->get($this->tblUserType);

        return $query->result_array();
    }

    public function isUniqueTeam_event($event_id, $team_name) {

        $query = $this->db->get_where($this->tblTeam, array('event_id' => $event_id, 'team_name' => $team_name));
        return $query->num_rows();
    }

    public function isUniqueTeam_eventForEdit($event_id, $team_name, $team_id) {

        $query = $this->db->get_where($this->tblTeam, array('event_id' => $event_id, 'team_name' => $team_name, 'team_name' => $team_name, 'id !=' => $team_id));
        return $query->num_rows();
    }

    public function InsertTeamDetails($data) {
        $this->db->insert($this->tblTeam, $data);
        return $this->db->insert_id();
    }

    public function InsertUserDetails($data) {
        $this->db->insert($this->tblUsers, $data);
    }

    public function isUserActivated($nonce) {

        $query = $this->db->get_where($this->tblUsers, array('nonce' => $nonce));
        return $query->num_rows();
    }

    public function userActivation($nonce) {
        $this->db->update($this->tblUsers, array('is_verified' => CONST_ACTIVATE, 'nonce' => ''), array('nonce' => $nonce));
    }

    public function isCarNumberSelected($team_id) {
        //return $team_id;
        $query = $this->db->select(array($this->tblTeam . '.car_id', $this->tblTeam . '.event_id'))
                ->join($this->tblUsers, $this->tblTeam . '.id = ' . $this->tblUsers . '.team_id')
                //->where($this->tblUsers . '.team_id', $team_id)
                ->get_where($this->tblTeam, array($this->tblUsers . '.team_id'=> $team_id));
                //->get($this->tblTeam);
       // return $this->db->last_query();
        return $query->row_array();
//        if (!empty($query)) {
//            $query = $query->row_array();
//            if ($query['car_id'] != '') {
//                echo 'ok';
////                return TRUE;
//            } else {
//                echo 'not';
//                return FALSE;
//            }
//        }
    }

    public function isCarNumberAvailable($event_id, $car_no, $team_id) {

        $query = $this->db->select('*')
                ->join($this->tblCarno, $this->tblTeam . '.car_id = ' . $this->tblCarno . '.id')
                ->where($this->tblTeam . '.event_id', $event_id)
                ->where($this->tblCarno . '.car_no', $car_no)
                ->get($this->tblTeam);

        return $query->row_array();
    }

    public function checkingCarNo($car_no, $event_id) {
        return $event_id;
        $query = $this->db->get_where($this->tblCarno, array('car_no' => $car_no, 'event_id' => $event_id));
        return $this->db->last_query();
        return $query->row_array();
    }

    public function addCarNo($team_id, $data) {
        $this->db->update($this->tblTeam, $data, array('id' => $team_id));
    }

    public function getUserEmailID($data) {
        $query = $this->db->get_where($this->tblUsers, $data);
//        return $query->row_array();
        return $query->result_array();
    }

    public function emailExistanceChecking($user_email_id) {
        $query = $this->db->get_where($this->tblUsers, array('user_email_id' => $user_email_id));
        return $query->row_array();
    }

    public function updateNonce($nonce, $id) {
        $this->db->update($this->tblUsers, array('nonce' => $nonce), array('id' => $id));
    }

    public function matchPassword($user_pwd, $nonce) {

        $query = $this->db->get_where($this->tblUsers, array('user_pwd' => $user_pwd, 'nonce' => $nonce));
        return $query->num_rows();
    }

    public function updateUserPassword($data, $nonce) {
        $this->db->update($this->tblUsers, $data, array('nonce' => $nonce));
    }

    public function getDetailsByNonce($nonce) {

        $query = $this->db->get_where($this->tblUsers, array('nonce' => $nonce));
        return $query->num_rows();
    }

    public function isTypeExists($team_id, $is_type) {

        $query = $this->db->get_where($this->tblUsers, array('team_id' => $team_id, 'is_type' => $is_type));
        return $query->num_rows();
    }

    public function updateUserDetails($data, $user_email_id) {
        $this->db->update($this->tblUsers, $data, array('user_email_id' => $user_email_id));
    }

    public function member_list($team_id) {

        $query = $this->db->order_by('is_type', 'DESC')->get_where($this->tblUsers, array('team_id' => $team_id));

        return $query->result_array();
    }

    public function delete_team_member($table_name, $id) {
        $this->db->where("id", $id);
        $this->db->delete($table_name);
    }

    public function check_renamed_email($user_email_id, $id) {
        $query = $this->db->get_where($this->tblUsers, array('user_email_id' => $user_email_id, 'id !=' => $id));
        return $query->num_rows();
    }

    public function reset_all_type($data, $team_id, $is_type) {
        $this->db->update($this->tblUsers, $data, array('team_id' => $team_id, 'is_type' => $is_type));
    }

    public function getMemberCountryName($country_id) {
        $query = $this->db->get_where($this->tblCountry, array('country_id' => $country_id));
        return $query->row_array();
    }

    public function getMemberStateName($state_id) {
        $query = $this->db->get_where($this->tblState, array('state_id' => $state_id));
        return $query->row_array();
    }

    public function getMemberCityName($city_id) {
        $query = $this->db->get_where($this->tblCity, array('city_id' => $city_id));
        return $query->row_array();
    }

    public function get_team_event_college_details($team_id) {

        $query = $this->db->select(array($this->tblTeam . '.college_id',
                    $this->tblTeam . '.event_id',
                    $this->tblTeam . '.team_name',
                    $this->tblCollege . '.college_name',
                    $this->tblEvents . '.event_name',
                    $this->tblTeam . '.img_logo'
                ))
                ->join($this->tblEvents, $this->tblEvents . '.id = ' . $this->tblTeam . '.event_id')
                ->join($this->tblCollege, $this->tblCollege . '.id = ' . $this->tblTeam . '.college_id')
                ->get_where($this->tblTeam, array($this->tblTeam . '.id' => $team_id));
        // return $this->db->last_query();
        return $query->row_array();
    }

    public function updateTeamDetails($data, $team_id) {
        $this->db->update($this->tblTeam, $data, array('id' => $team_id));
        // echo $this->db->last_query();die;
    }
    public function listofOfficialMembers() {
        $query = $this->db->select(array($this->tblUsers . '.id', $this->tblUsers . '.user_name', $this->tblUsers . '.user_email_id'))
                ->get_where($this->tblUsers, array('is_type' => CONST_USER_OFFICIAL, 'is_verified' => CONST_VERIFICATION_ACTIVATE, 'is_status' => CONST_ACTIVATE));
        return $query->result_array();
    }

    public function responsible_person_details($id) {
        $query = $this->db->select(array($this->tblUsers . '.user_email_id', $this->tblUsers . '.user_name'))
                ->get_where($this->tblUsers, array('id' => $id, 'is_type' => CONST_USER_OFFICIAL, 'is_verified' => CONST_VERIFICATION_ACTIVATE, 'is_status' => CONST_ACTIVATE));
        return $query->row_array();
    }

}
