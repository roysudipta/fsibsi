<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('College_model');
        $logged_page = array('userActivation', 'ajaxData', 'login', 'authenticate_user','validateDate', 'isUniqueTeam', 'isUniqueTeamForEdit', 'forgot_password', 'forgot_email', 'recoverCredential', 'change_password', 'changePasswordSubmit', 'set_password');
         $pageName = $this->uri->segment(1);
//        if (!in_array($pageName, $logged_page)) {
//
//            if ($this->session->userdata('session_user') != '') {
//                $session = $this->session->userdata('session_user');
//
//                $url = '';
//                switch ($session['is_type']) {
//
//                    case CONST_USER_ADMIN:
//                        $url = base_url() . FN_ADMIN_DASHBOARD;
//                        break;
//                    case CONST_USER_CAPTAIN:
//                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
//                        break;
//                    case CONST_USER_OFFICIAL:
//                        $url = base_url() . FN_OFFICIAL_DASHBOARD;
//                        break;
//                    case CONST_USER_VICECAPTAIN:
//                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
//                        break;
//                    case CONST_USER_TEAMMEMBER:
//                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
//                        break;
//                    case CONST_USER_FACULTY:
//                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
//                        break;
//                }
//                redirect($url);
//            }
//        }
    }

    public function login() {

        $this->_FrontView(PAGE_FRONT_AUTH_LOGIN);
    }

    public function registration() {
        $data['countries'] = $this->User_model->listCountry();
        $data['ListEvent'] = $this->User_model->ListEvent();
        $data['listColleges'] = $this->College_model->listColleges(array('select' => array('id', 'college_name'), 'order_by' => 'college_name'));
        $data['securityQuestions'] = $this->User_model->ListQuestion();

        $this->_FrontView(PAGE_FRONT_AUTH_REGISTRATION, $data);
    }

    public function ajaxData() {
        $countryID = $this->input->post('country_id');
        $stateId = $this->input->post('state_id');

        if (isset($countryID) && !empty($countryID)) {

            $states = $this->User_model->listState($countryID);

            //Display states list

            echo '<option value="0">Select state</option>';
            foreach ($states as $values) {
                echo '<option value="' . $values['state_id'] . '">' . $values['state_name'] . '</option>';
            }
        }

        if (isset($stateId) && !empty($stateId)) {
            //Get all city data
            $cities = $this->User_model->listCity($stateId);


            echo '<option value="0">Select city</option>';
            foreach ($cities as $values) {
                echo '<option value="' . $values['city_id'] . '">' . $values['city_name'] . '</option>';
            }
        }
    }

    public function validateDate($date, $format = 'YYYY-MM-DD') {
        switch ($format) {
            case 'YYYY/MM/DD':
            case 'YYYY-MM-DD':
                list( $y, $m, $d ) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'YYYY/DD/MM':
            case 'YYYY-DD-MM':
                list( $y, $d, $m ) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'DD-MM-YYYY':
            case 'DD/MM/YYYY':
                list( $d, $m, $y ) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'MM-DD-YYYY':
            case 'MM/DD/YYYY':
                list( $m, $d, $y ) = preg_split('/[-\.\/ ]/', $date);
                break;

            case 'YYYYMMDD':
                $y = substr($date, 0, 4);
                $m = substr($date, 4, 2);
                $d = substr($date, 6, 2);
                break;

            case 'YYYYDDMM':
                $y = substr($date, 0, 4);
                $d = substr($date, 4, 2);
                $m = substr($date, 6, 2);
                break;

            default:
                throw new Exception("Invalid Date Format");
        }
        return checkdate($m, $d, $y);
    }

    public function FormRegistration() {

        $event_id = trim(addslashes($this->input->post("event_id")));
        $team_name = trim(addslashes($this->input->post("team_name")));
        $college_id = trim(addslashes($this->input->post("college_id")));
        $user_email_id = trim(addslashes($this->input->post("user_email_id")));
        $date_of_birth = trim(addslashes($this->input->post("date_of_birth")));
        $formattedDate = date('Y-m-d', strtotime($date_of_birth));

        $user_name = trim(addslashes($this->input->post("user_name")));
        $question1 = trim(addslashes($this->input->post("question1")));
        $answer1 = trim(addslashes($this->input->post("answer1")));
        $question2 = trim(addslashes($this->input->post("question2")));
        $answer2 = trim(addslashes($this->input->post("answer2")));
        $user_pwd = trim(addslashes($this->input->post("user_pwd")));
        $cpwd = trim(addslashes($this->input->post("cpwd")));
        $user_address = trim(addslashes($this->input->post("user_address")));
        $country_id = trim(addslashes($this->input->post("country_id")));
        $state_id = trim(addslashes($this->input->post("state_id")));
        $city_id = trim(addslashes($this->input->post("city_id")));
        $pin = trim(addslashes($this->input->post("pin")));
        $isUniqueTeam_event = $this->User_model->isUniqueTeam_event($event_id, $team_name);
        $this->form_validation->set_rules('user_email_id', 'Email', 'required|valid_email|is_unique[fbsi_users.user_email_id]');
        $this->form_validation->set_rules('user_name', 'Username', 'required');
        $dateValidation = '';
        if ($date_of_birth != '') {
            $dateValidation = $this->validateDate($date_of_birth, 'MM/DD/YYYY');
        }

        if ($team_name == '') {
            echo 'team_name~Team name can not be blank.';
        } else if ($isUniqueTeam_event > 0) {
            echo 'team_name~Given team name is already registered with selected event. Change the team name and try again.';
        } else if ($college_id == 0) {
            echo 'college_id~Please choose your college name.';
        } else if ($this->form_validation->run() == false && form_error('user_name')) {
            echo 'user_name~Username can not be blank.';
        } else if ($this->form_validation->run() == false && form_error('user_email_id')) {
            echo 'user_email_id~Email must be valid and unique.';
        } else if ($date_of_birth == '') {
            echo 'date_of_birth~Captain\'s date of birth can not be blank.';
        } else if ($dateValidation == false) {
            echo 'date_of_birth~Captain\'s date of birth must be in format of "MM/DD/YYYY".';
        } else if ($question1 == 0) {
            echo 'question1~Please choose your first Security Question.';
        } else if ($answer1 == '') {
            echo 'answer1~Answer of first Security Question can not be blank.';
        } else if ($question2 == 0) {
            echo 'question2~Please choose your second Security Question.';
        } else if ($answer2 == '') {
            echo 'answer2~Answer of second Security Question can not be blank.';
        } else if ($user_pwd == '') {
            echo 'user_pwd~Password can not be blank.';
        } else if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $user_pwd)) {
            echo 'user_pwd~Password must contain one lowercase, one uppercase character, one digit, one special sign and 8-12 characters';
        } else if ($cpwd == '') {
            echo 'cpwd~Confirm password can not be blank.';
        } else if ($cpwd != $user_pwd) {
            echo 'cpwd~Password does not match.';
        } else if ($user_address == '') {
            echo 'user_address~Address can not be blank.';
        } else if ($country_id == 0) {
            echo 'country_id~Please choose your country name.';
        } else if ($state_id == 0) {
            echo 'state_id~Please choose your state name.';
        } else if ($city_id == 0) {
            echo 'city_id~Please choose your city name.';
        } else if ($pin == '') {
            echo 'city_id~Pin code can not be blank.';
        } else {
            $nonce = md5(date('Y-m-d H:i:s'));

            $data = array
                (
                'college_id' => $college_id,
                'event_id' => $event_id,
                'team_name' => $team_name,
                'address' => $user_address,
                'city_id' => $city_id,
                'state_id' => $state_id,
                'country_id' => $country_id
            );

            $team_id = $this->User_model->InsertTeamDetails($data);
            $UserData = array
                (
                'user_name' => $user_name,
                'date_of_birth' => $formattedDate,
                'user_email_id' => $user_email_id,
                'user_uid' => md5($user_email_id),
                'user_pwd' => md5($user_pwd),
                'user_address' => $user_address,
                'question1' => $question1,
                'answer1' => $answer1,
                'question2' => $question2,
                'answer2' => $answer2,
                'city_id' => $city_id,
                'state_id' => $state_id,
                'country_id' => $country_id,
                'pin' => $pin,
                'team_id' => $team_id,
                'is_type' => CONST_USER_CAPTAIN,
                'nonce' => $nonce,
            );
            $this->User_model->InsertUserDetails($UserData);

            $query = array
                (
                'user_email_id' => $user_email_id,
                'nonce' => $nonce,
            );
            $body = $this->load->view(PAGE_TEMPLATE_EMAIL_CONFIRMATION, $query, TRUE);
            $this->load->model('mailer');

            $this->mailer->sendMail(array(
                'to' => array(
                    'email' => $user_email_id,
                    'name' => 'info@fsi-bsi.com'
                ),
                'subject' => 'eMail Confirmation',
                'body' => $body,
            ));

            echo 'success';
        }
    }

    public function isUniqueTeam() {
        $event_id = trim(addslashes($this->input->post("event_id")));
        $team_name = trim(addslashes($this->input->post("team_name")));
        $user_email = trim(addslashes($this->input->post("user_email")));
        $this->form_validation->set_rules('team_name', 'Team Name', 'trim|required');


        $isUniqueTeam_event = $this->User_model->isUniqueTeam_event($event_id, $team_name);
        if ($this->form_validation->run() == false && form_error('team_name')) {
            echo 'team_name~Team name can not be blank.';
        } else if ($isUniqueTeam_event > 0) {
            echo 'team_name~Given team name is already registered with selected event. Change the team name and try again.';
        }
        /* else
          {
          echo 'success';
          } */
    }

    public function isUniqueTeamForEdit() {
        $event_id = trim(addslashes($this->input->post("event_id")));
        $team_name = trim(addslashes($this->input->post("team_name")));
        $team_id = trim(addslashes($this->input->post("team_id")));
        $college_id = trim(addslashes($this->input->post("college_id")));
        $this->form_validation->set_rules('team_name', 'Team Name', 'trim|required');


        $isUniqueTeam_eventForEdit = $this->User_model->isUniqueTeam_eventForEdit($event_id, $team_name, $team_id);
        if ($this->form_validation->run() == false && form_error('team_name')) {
            echo 'team_name~Team name can not be blank.';
        } else if ($isUniqueTeam_eventForEdit > 0) {
            echo 'team_name~Given team name is already registered with selected event. Change the team name and try again.';
        } else if ($college_id == 0) {
            echo 'college_id~Please choose your college name.';
        } else {
            echo 'success';
        }
    }

    public function userActivation($nonce) {
        //$this->session->unset_userdata('session_user');
        $isUserActivated = $this->User_model->isUserActivated($nonce);

        if ($isUserActivated > 0) {
            $this->User_model->userActivation($nonce);
            $data['activation_status'] = 'Your account has been successfully activated.';
        } else {
            $data['activation_status'] = 'Your account has already been activated.';
        }
        $this->_FrontView(PAGE_FRONT_AUTH_EMAIL_VERIFICATION, $data);
        $this->output->set_header('refresh:2; url=' . base_url() . CONTROLLER_FRONT_DASHBOARD_CAPTAIN);
    }

    public function authenticate_user() {

        $uid = xss_clean($this->input->post('uid'));
        $pwd = xss_clean($this->input->post('pwd'));

        $user = $this->User_model->authenticate($uid, $pwd);
        if ($uid == '') {
            echo 'uid~User ID can not be blank.';
            return 0;
        } elseif (!filter_var($uid, FILTER_VALIDATE_EMAIL)) {
            echo 'uid~Please enter a valid email address.';
            return 0;
        } else if ($pwd == '') {
            echo 'pwd~Password can not be blank.';
            return 0;
        } else if (empty($user)) {
            echo 'alert~You have entered a wrong credential.';
            return 0;
        } elseif ($user['is_verified'] == '0') {
            echo 'alert~Your account is not yet activated.';
            return 0;
        }

        $data['session_user'] = array(
            'id' => $user['id'],
            'email' => $user['user_email_id'],
            'uid' => $user['user_uid'],
            'name' => $user['user_name'],
            'team_id' => $user['team_id'],
            'is_type' => $user['is_type'],
            'is_verified' => $user['is_verified'],
            'is_status' => $user['is_status'],
            'profile_pic' => $user['img_profile'],
            'cover_pic' => $user['img_cover']);

        $this->session->set_userdata($data);

        $session_id = $this->session->userdata('session_user');
        $url = '';

        switch ($user['is_type']) {

            case CONST_USER_ADMIN:
                $url = base_url() . FN_ADMIN_DASHBOARD;
                break;
            case CONST_USER_CAPTAIN:
                $url = base_url() . FN_CAPTAIN_DASHBOARD;
                break;
            case CONST_USER_OFFICIAL:
                $url = base_url() . FN_CAPTAIN_DASHBOARD;
                break;
            case CONST_USER_VICECAPTAIN:
                $url = base_url() . FN_CAPTAIN_DASHBOARD;
                break;
            case CONST_USER_TEAMMEMBER:
                $url = base_url() . FN_CAPTAIN_DASHBOARD;
                break;
            case CONST_USER_FACULTY:
                $url = base_url() . FN_CAPTAIN_DASHBOARD;
                break;
        }

        echo 'success~<div class="success-msg">' . $this->lang->line(MSG_SCS_LOGIN) . '</div>~' . $url;
    }

    public function forgot_email() {
        $data['securityQuestions'] = $this->User_model->ListQuestion();

        $this->_FrontView(PAGE_FRONT_AUTH_FORGOT_CREDENTIAL, $data);
    }

    public function forgot_password() {

        $this->_FrontView(PAGE_FRONT_AUTH_FORGOT_CREDENTIAL);
    }

    public function recoverCredential() {
        $type = trim(addslashes($this->input->post("type")));
        if ($type == 'emailRecover') {
            $date_of_birth = trim(addslashes($this->input->post("date_of_birth")));
            $question1 = trim(addslashes($this->input->post("question1")));
            $answer1 = trim(addslashes($this->input->post("answer1")));
            $question2 = trim(addslashes($this->input->post("question2")));
            $answer2 = trim(addslashes($this->input->post("answer2")));
            $formattedDate = date('Y-m-d', strtotime($date_of_birth));
            $dateValidation = '';
            if ($date_of_birth != '') {
                $dateValidation = $this->validateDate($date_of_birth, 'MM/DD/YYYY');
            }

            if ($date_of_birth == '') {
                echo 'date_of_birth~Date of birth can not be blank.';
            } else if ($dateValidation == false) {
                echo 'date_of_birth~Captain\'s date of birth must be in format of "MM/DD/YYYY".';
            } else if ($question1 == 0) {
                echo 'question1~Please choose your first Security Question.';
            } else if ($answer1 == '') {
                echo 'answer1~Answer of first Security Question can not be blank.';
            } else if ($question2 == 0) {
                echo 'question2~Please choose your second Security Question.';
            } else if ($answer2 == '') {
                echo 'answer2~Answer of second Security Question can not be blank.';
            } else {
                $data = array('date_of_birth' => $formattedDate, 'question1' => $question1, 'answer1' => $answer1, 'question2' => $question2, 'answer2' => $answer2);
                $getUserEmailID = $this->User_model->getUserEmailID($data);
                
                if (!empty($getUserEmailID)) {
                    echo 'success~';
                    foreach($getUserEmailID as $row_getUserEmailID)
                    {
                        echo '<div class="success-msg">Congratulations! Your Email ID has been successfully recovered and it is <strong>"' . $row_getUserEmailID['user_email_id'] . '"</strong>.</div>';
                    }
                    
                } else {
                    echo 'alert~<div class="error-msg">Sorry! There is no Email ID according to your given details..</div>';
                }
            }
        } else if ($type == 'passwordRecover') {
            $user_email_id = trim(addslashes($this->input->post("user_email_id")));
            $this->form_validation->set_rules('user_email_id', 'Email', 'required|valid_email');
            $emailExistanceChecking = $this->User_model->emailExistanceChecking($user_email_id);

            if ($this->form_validation->run() == false && form_error('user_email_id')) {
                echo 'user_email_id~Please enter a valid Email ID.';
            } else if ($emailExistanceChecking['user_email_id'] == '') {
                echo 'alert~<div class="error-msg">Email ID is not registered yet.</div>';
            } else {

                $nonce = md5(date('Y-m-d H:i:s'));
                $this->User_model->updateNonce($nonce, $emailExistanceChecking['id']);
                $query = array
                    (
                    'user_email_id' => $user_email_id,
                    'nonce' => $nonce,
                    'user_name' => $emailExistanceChecking['user_name'],
                );
                $body = $this->load->view(PAGE_TEMPLATE_PASSWORD_CHANGE, $query, TRUE);
                $this->load->model('mailer');

                $this->mailer->sendMail(array(
                    'to' => array(
                        'email' => $user_email_id,
                        'name' => 'info@fsi-bsi.com'
                    ),
                    'subject' => 'Reset Password',
                    'body' => $body,
                ));
                echo 'success~<div class="success-msg">Password reset link has been sent to your registered Email ID.</div>';
            }
        }
    }

    public function change_password($nonce) {
        $this->session->unset_userdata('session_user');
        $data['nonce'] = $nonce;
        $data['getDetailsByNonce'] = $this->User_model->getDetailsByNonce($nonce);
        $this->_FrontView(PAGE_FRONT_AUTH_CHANGE_PASSWORD, $data);
    }

    public function changePasswordSubmit() {
        $user_pwd = trim(addslashes($this->input->post("user_pwd")));
        $cpwd = trim(addslashes($this->input->post("cpwd")));
        $nonce = trim(addslashes($this->input->post("nonce")));

        $matchPassword = $this->User_model->matchPassword(md5($user_pwd), $nonce);
        if ($user_pwd == '') {
            echo 'user_pwd~Password can not be blank.';
        } else if (!preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $user_pwd)) {
            echo 'user_pwd~Password must contain one lowercase, one uppercase character, one digit, one special sign and 8-12 characters';
        } else if ($matchPassword > 0) {
            echo 'user_pwd~You have entered your old password.';
        } else if ($cpwd == '') {
            echo 'cpwd~Confirm password can not be blank.';
        } else if ($cpwd != $user_pwd) {
            echo 'cpwd~Password does not match.';
        } else {
            $data = array('nonce' => '', 'user_pwd' => md5($user_pwd));
            $this->User_model->updateUserPassword($data, $nonce);
            echo 'success~<div class="success-msg">Congratulations! You have successfully changed your password.</div>';
        }
    }

    public function set_password($nonce) {
        $this->session->unset_userdata('session_user');
        $data['nonce'] = $nonce;

        $data['getDetailsByNonce'] = $this->User_model->getDetailsByNonce($nonce);
        $this->_FrontView(PAGE_FRONT_AUTH_SET_PASSWORD, $data);
    }

    public function logout() {
        $this->session->unset_userdata('session_user');
        redirect(base_url() . FN_LOGIN);
    }

}
