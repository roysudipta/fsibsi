<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Captain_dashboard extends FB_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Event_model');
        $this->load->model('College_model');
        $logged_page = array('set_password', 'set_team_details','checkCarNoExisting','');
        $pageName = $this->uri->segment(2);
//        if (!in_array($pageName, $logged_page)) {
//            if ($this->session->userdata('session_user') == '') {
//                redirect(site_url(CONTROLLER_AUTH . 'login'));
//            }
//        }
    }

    public function index() {
        $data['listColleges'] = $this->College_model->listColleges(array('select' => array('id', 'college_name'), 'order_by' => 'college_name'));
        $session_user = $this->session->userdata('session_user');
       // echo $session_user['team_id'];die;
        $data['ListEvent'] = $this->Event_model->listEvents(array('where'=>'is_ongoing='.CONST_ACTIVATE));
        $data['get_team_event_college_details'] = $this->User_model->get_team_event_college_details($session_user['team_id']);
        $data['isCarNumberSelected'] = $this->User_model->isCarNumberSelected($session_user['team_id']);
       // print_r( $data['isCarNumberSelected']);die;
        $data['member_list'] = $this->User_model->member_list($session_user['team_id']);
        $data['member_details'] = $this->User_model->getUser($session_user['id']);
        $data['getMemberCountryName'] = $this->User_model->getMemberCountryName($data['member_details']['country_id']);

        $data['getMemberStateName'] = $this->User_model->getMemberStateName($data['member_details']['state_id']);
        $data['getMemberCityName'] = $this->User_model->getMemberCityName($data['member_details']['city_id']);
        $data['listCountry'] = $this->User_model->listCountry();
        $data['listState'] = $this->User_model->listState($data['member_details']['country_id']);

        $data['listCity'] = $this->User_model->listCity($data['member_details']['state_id']);
        $this->_FrontView(PAGE_FRONT_DASHBOARD_CAPTAIN, $data);
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

    public function checkCarNoExisting() {
        $car_no = $this->input->post('car_no');
         $event_id = $this->input->post('event_id');
        $ajax_type = $this->input->post('ajax_type');
        $session_user = $this->session->userdata('session_user');
        $CountCarNO = $this->User_model->isCarNumberAvailable($event_id, $car_no, $session_user['team_id']);
        echo $getCarNo = $this->User_model->checkingCarNo($car_no, $event_id);die;
        $count = 0;
        if ($car_no == '') {
            echo '<div class="input-error">The car number can not be blank.</div>';
            $count++;
        } elseif ($getCarNo == NULL) {
            echo '<div class="input-error">The car number is invalid. It must be within the range of 11-999.</div>';
            $count++;
        } else if ($CountCarNO > 0) {
            echo '<div class="input-error">The car number is not available. It has already booked.</div>';
            $count++;
        } else if ($CountCarNO == 0) {
            echo '<div class="input-success">The car number is available.</div>';
            $count = 0;
        }
        if ($ajax_type == 'submit' && $count == 0) {
            $data = array('car_id' => $getCarNo['id']);
            $this->User_model->addCarNo($session_user['team_id'], $data);
            echo '~success';
        }
    }

    public function add_member() {
        $user_type = addslashes($this->input->post("user_type"));
        $user_name = addslashes($this->input->post("user_name"));
        $user_email_id = addslashes($this->input->post("user_email_id"));
        $team_id = addslashes($this->input->post("team_id"));
        $this->form_validation->set_rules('user_email_id', 'Email', 'required|valid_email|is_unique[fbsi_users.user_email_id]');
        $isFacultyExists = 0;
        if ($user_type == 5 || $user_type == 7) {
            $isTypeExists = $this->User_model->isTypeExists($team_id, $user_type);
        }
        if ($user_type != 6 && $user_type != 5 && $user_type != 7) {
            echo 'user_type~Please choose a valid member type.';
        } elseif ($user_type == 5 && $isTypeExists > 0) {
            echo 'user_type~You have already chosen your Vice Captain for your team.';
        } elseif ($user_type == 7 && $isTypeExists > 0) {
            echo 'user_type~You have already chosen your Faculty for your team.';
        } elseif ($user_name == '') {
            echo 'user_name~Name can not be blank.';
        } else if ($this->form_validation->run() == false && form_error('user_email_id')) {
            echo 'user_email_id~Email must be valid and unique.';
        } else {
            $nonce = md5(date('Y-m-d H:i:s'));
            $UserData = array
                (
                'user_name' => $user_name,
                'user_email_id' => $user_email_id,
                'user_uid' => md5($user_email_id),
                'user_pwd' => md5($user_email_id),
                'team_id' => $team_id,
                'is_type' => $user_type,
                'is_status' => CONST_DEACTIVATE,
                'nonce' => $nonce,
            );
            $this->User_model->InsertUserDetails($UserData);


            $query = array
                (
                'user_email_id' => $user_email_id,
                'nonce' => $nonce,
                'user_name' => $user_name,
            );
            $body = $this->load->view(PAGE_TEMPLATE_TEAM_MAIL_ACTIVATION, $query, TRUE);
            $this->load->model('mailer');

            $this->mailer->sendMail(array(
                'to' => array(
                    'email' => $user_email_id,
                    'name' => 'info@fsi-bsi.com'
                ),
                'subject' => 'Set Password',
                'body' => $body,
            ));
            echo 'success~<div class="success-msg">Congratulations! New member has been added successfully.</div>';
        }
    }

    public function set_password($nonce) {
        $data['countries'] = $this->User_model->listCountry();
        $data['securityQuestions'] = $this->User_model->ListQuestion();
        $this->session->unset_userdata('session_user');
        $data['nonce'] = $nonce;

        $data['getDetailsByNonce'] = $this->User_model->getDetailsByNonce($nonce);
        $this->_FrontView(PAGE_FRONT_AUTH_SET_PASSWORD, $data);
    }

    public function set_team_details() {

        $date_of_birth = trim(addslashes($this->input->post("date_of_birth")));
        $question1 = trim(addslashes($this->input->post("question1")));
        $answer1 = trim(addslashes($this->input->post("answer1")));
        $question2 = trim(addslashes($this->input->post("question2")));
        $answer2 = trim(addslashes($this->input->post("answer2")));
        $user_pwd = trim(addslashes($this->input->post("user_pwd")));
        $cpwd = trim(addslashes($this->input->post("cpwd")));
        $nonce = trim(addslashes($this->input->post("nonce")));
        $formattedDate = date('Y-m-d', strtotime($date_of_birth));

        $dateValidation = '';
        if ($date_of_birth != '') {
            $dateValidation = $this->validateDate($date_of_birth, 'MM/DD/YYYY');
        }

        if ($date_of_birth == '') {
            echo 'date_of_birth~Date of birth can not be blank.';
        } else if ($dateValidation == false) {
            echo 'date_of_birth~Date of birth must be in format of "MM/DD/YYYY".';
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
        } else {


            $UserData = array(
                'date_of_birth' => $formattedDate,
                'user_pwd' => md5($user_pwd),
                'question1' => $question1,
                'answer1' => $answer1,
                'question2' => $question2,
                'answer2' => $answer2,
                'is_status' => CONST_ACTIVATE,
                'is_verified' => CONST_ACTIVATE,
                'nonce' => '',
            );
            $this->User_model->updateUserPassword($UserData, $nonce);
            echo 'success~' . $this->lang->line(MSG_SCS_ADD_TEAM);
        }
    }

    public function edit_captain_and_team_details() {
        $college_id = trim(addslashes($this->input->post("college_id")));
        $college_id = trim(addslashes($this->input->post("college_id")));
        $college_id = trim(addslashes($this->input->post("college_id")));
    }

    public function set_cover_picture() {

        $img_cover = $_FILES["img_cover"]["name"];
        $img_size = $_FILES["img_cover"]["size"];
        $img_type = $_FILES["img_cover"]["type"];
        $session_user = $this->session->userdata('session_user');
        $user_details = $this->User_model->emailExistanceChecking($session_user['email']);

        $validextensions = array("jpeg", "jpg", "png", "gif");
        $temporary = explode(".", $img_cover);
        $file_extension = end($temporary);

        $width = $this->input->post("width");
        $height = $this->input->post("height");
        if ($img_cover == '') {
            echo 'img_cover~Please upload your cover picture.';
        } elseif (($img_type != "image/png" || $img_type != "image/jpg" || $img_type != "image/jpeg" || $img_type != "image/gif") && $img_size > 100000 && !in_array($file_extension, $validextensions)) {
            echo 'img_cover~Uploaded picture must be in jpg,jpeg,png format and less than 10MB.';
        } elseif ($width > USER_PROFILE_COVER_IMAGE_WIDTH_MAX || $height > USER_PROFILE_COVER_IMAGE_HEIGHT_MAX) {
            echo 'img_cover~Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be less than or equal ' . USER_PROFILE_COVER_IMAGE_WIDTH_MAX . 'X' . USER_PROFILE_COVER_IMAGE_HEIGHT_MAX . '.';
        } elseif ($width < USER_PROFILE_COVER_IMAGE_WIDTH_MIN || $height < USER_PROFILE_COVER_IMAGE_HEIGHT_MIN) {
            echo 'img_cover~Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be greater than or equal ' . USER_PROFILE_COVER_IMAGE_WIDTH_MIN . 'X' . USER_PROFILE_COVER_IMAGE_HEIGHT_MIN . '.';
        } else {
            $filename = md5(time()) . '_' . $img_cover;
            move_uploaded_file($_FILES["img_cover"]["tmp_name"], CONST_PATH_PROFILE_COVER_IMAGE . $filename);
            if ($user_details['img_cover'] != '') {
                unlink(CONST_PATH_PROFILE_COVER_IMAGE . $user_details['img_cover']);
            }


            $data_values = array('img_cover' => $filename);
            $this->User_model->updateUserDetails($data_values, $session_user['email']);

            $data['session_user'] = array(
                'id' => $session_user['id'],
                'email' => $session_user['email'],
                'uid' => $session_user['uid'],
                'name' => $session_user['name'],
                'team_id' => $session_user['team_id'],
                'is_type' => $session_user['is_type'],
                'is_verified' => $session_user['is_verified'],
                'is_status' => $session_user['is_status'],
                'profile_pic' => $session_user['profile_pic'],
                'cover_pic' => $filename
            );

            $this->session->set_userdata($data);
            echo 'success~' . base_url() . CONST_PATH_PROFILE_COVER_IMAGE . $filename;
        }
    }

    public function set_profile_picture() {

        $img_profile = $_FILES["img_profile"]["name"];
        $img_size = $_FILES["img_profile"]["size"];
        $img_type = $_FILES["img_profile"]["type"];
        $session_user = $this->session->userdata('session_user');
        $user_details = $this->User_model->emailExistanceChecking($session_user['email']);

        $validextensions = array("jpeg", "jpg", "png", "gif");
        $temporary = explode(".", $img_profile);
        $file_extension = end($temporary);

        $width = $this->input->post("width");
        $height = $this->input->post("height");
        if ($img_profile == '') {
            echo 'img_profile~Please upload your profile picture.';
        } elseif (($img_type != "image/png" || $img_type != "image/jpg" || $img_type != "image/jpeg" || $img_type != "image/gif") && $img_size > 100000 && !in_array($file_extension, $validextensions)) {
            echo 'img_profile~Uploaded picture must be in jpg,jpeg,png format and less than 10MB.';
        } elseif ($width > USER_PROFILE_IMAGE_WIDTH_MAX || $height > USER_PROFILE_IMAGE_HEIGHT_MAX) {
            echo 'img_profile~Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be less than or equal ' . USER_PROFILE_IMAGE_WIDTH_MAX . 'X' . USER_PROFILE_IMAGE_HEIGHT_MAX . '.';
        } elseif ($width < USER_PROFILE_IMAGE_WIDTH_MIN || $height < USER_PROFILE_IMAGE_HEIGHT_MIN) {
            echo 'img_profile~Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be greater than or equal ' . USER_PROFILE_IMAGE_WIDTH_MIN . 'X' . USER_PROFILE_IMAGE_HEIGHT_MIN . '.';
        } else {
            $filename = md5(time()) . '_' . $img_profile;
            move_uploaded_file($_FILES["img_profile"]["tmp_name"], CONST_PATH_PROFILE_IMAGE . $filename);
            if ($user_details['img_profile'] != '') {
                unlink(CONST_PATH_PROFILE_IMAGE . $user_details['img_profile']);
            }


            $data_values = array('img_profile' => $filename);
            $this->User_model->updateUserDetails($data_values, $session_user['email']);

            $data['session_user'] = array(
                'id' => $session_user['id'],
                'email' => $session_user['email'],
                'uid' => $session_user['uid'],
                'name' => $session_user['name'],
                'team_id' => $session_user['team_id'],
                'is_type' => $session_user['is_type'],
                'is_verified' => $session_user['is_verified'],
                'is_status' => $session_user['is_status'],
                'profile_pic' => $filename,
                'cover_pic' => $session_user['cover_pic']
            );

            $this->session->set_userdata($data);
            echo 'success~' . base_url() . CONST_PATH_PROFILE_IMAGE . $filename;
        }
    }

    public function set_team_logo() {

        $team_logo = $_FILES["team_logo"]["name"];
        $img_size = $_FILES["team_logo"]["size"];
        $img_type = $_FILES["team_logo"]["type"];
        $session_user = $this->session->userdata('session_user');


        $validextensions = array("jpeg", "jpg", "png", "gif");
        $temporary = explode(".", $team_logo);
        $file_extension = end($temporary);

        $width = $this->input->post("width");
        $height = $this->input->post("height");
        $team_Logo_image = $this->input->post("team_Logo_image");
        if ($team_logo == '') {
            echo 'team_logo~Please upload your profile picture.';
        } elseif (($img_type != "image/png" || $img_type != "image/jpg" || $img_type != "image/jpeg" || $img_type != "image/gif") && $img_size > 100000 && !in_array($file_extension, $validextensions)) {
            echo 'team_logo~Uploaded picture must be in jpg,jpeg,png format and less than 10MB.';
        } elseif ($width > USER_TEAM_LOGO_WIDTH_MAX || $height > USER_TEAM_LOGO_HEIGHT_MAX) {
            echo 'team_logo~Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be less than or equal to ' . USER_TEAM_LOGO_WIDTH_MAX . 'X' . USER_TEAM_LOGO_HEIGHT_MAX . '.';
        } elseif ($width < USER_TEAM_LOGO_WIDTH_MIN || $height < USER_TEAM_LOGO_HEIGHT_MIN) {
            echo 'team_logo~Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be greater than or equal ' . USER_TEAM_LOGO_WIDTH_MIN . 'X' . USER_TEAM_LOGO_HEIGHT_MIN . '.';
        } else {
            $filename = md5(time()) . '_' . $team_logo;
            move_uploaded_file($_FILES["team_logo"]["tmp_name"], CONST_PATH_TEAM_LOGO . $filename);
            if ($team_Logo_image != '') {
                unlink(CONST_PATH_TEAM_LOGO . $team_Logo_image);
            }


            $data_values = array('img_logo' => $filename);
            $this->User_model->updateTeamDetails($data_values, $session_user['team_id']);


            echo 'success~' . base_url() . CONST_PATH_TEAM_LOGO . $filename;
        }
    }

    public function delete_team_member() {
        $table_name = $this->input->post("table_name");
        $id = $this->input->post("id");
        $this->User_model->delete_team_member($table_name, $id);
        echo 'success~Team member has been successfully deleted.';
    }

    public function change_user_details() {
        $user_name = trim(addslashes($this->input->post("user_name")));
        $user_email_id = trim(addslashes($this->input->post("user_email_id")));
        $is_type = trim(addslashes($this->input->post("is_type")));
        $team_id = trim(addslashes($this->input->post("team_id")));
        $id = trim(addslashes($this->input->post("id")));

        $check_renamed_email = $this->User_model->check_renamed_email($user_email_id, $id);
        $match_emailids = $this->User_model->getUser($id);
        if ($user_name == '') {
            echo 'action_' . $id . '~' . 'changed_user_name' . $id . '~ Name can not be blank.';
        } else if ($user_email_id == '' || !filter_var($user_email_id, FILTER_VALIDATE_EMAIL) || $check_renamed_email > 0) {
            echo 'action_' . $id . '~' . 'changed_user_email_id' . $id . '~Email must be valid and unique.';
        } else {
            if ($is_type == CONST_USER_VICECAPTAIN || $is_type == CONST_USER_FACULTY) {
                $data = array(
                    'is_type' => CONST_USER_TEAMMEMBER,
                );
                $this->User_model->reset_all_type($data, $team_id, $is_type);
            }

            if ($match_emailids['user_email_id'] != $user_email_id) {
                $nonce = md5(date('Y-m-d H:i:s'));
                $data = array(
                    'user_name' => $user_name,
                    'user_email_id' => $user_email_id,
                    'user_uid' => md5($user_email_id),
                    'nonce' => $nonce,
                    'is_type' => $is_type,
                    'is_verified' => CONST_VERIFICATION_DEACTIVATE,
                    'is_status' => CONST_VERIFICATION_DEACTIVATE,
                );
                $this->User_model->updateUser($data, $id);
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
                echo 'success_mail~' . 'action_' . $id . '~Details has been updated.';
            } else {
                $data = array(
                    'user_name' => $user_name,
                    'is_type' => $is_type,
                );
                $this->User_model->updateUser($data, $id);
                echo 'success~' . 'action_' . $id . '~<div class="success-msg">Details has been updated.</div>';
            }
        }
    }

    public function change_user_address() {
        $user_address = trim(addslashes($this->input->post("user_address")));
        $country_id = trim(addslashes($this->input->post("country_id")));
        $state_id = trim(addslashes($this->input->post("state_id")));
        $city_id = trim(addslashes($this->input->post("city_id")));
        $pin = trim(addslashes($this->input->post("pin")));
        $id = trim(addslashes($this->input->post("id")));
        if ($user_address == '') {
            echo 'user_address~Address can not be blank.';
        } else if ($country_id == 0) {
            echo 'country_id~Please choose your country name.';
        } else if ($state_id == 0) {
            echo 'state_id~Please choose your state name.';
        } else if ($city_id == 0) {
            echo 'city_id~Please choose your city name.';
        } else if ($pin == '') {
            echo 'pin~Pin code can not be blank.';
        } else {
            $data = array(
                'user_address' => $user_address,
                'city_id' => $city_id,
                'state_id' => $state_id,
                'country_id' => $country_id,
                'pin' => $pin,
            );
            $this->User_model->updateUser($data, $id);
            echo 'success~<div class="success-msg">New address has been updated.</div>';
        }
    }

    public function change_team_details() {
        $event_id = trim(addslashes($this->input->post("event_id")));
        $team_name = trim(addslashes($this->input->post("team_name")));
        $college_id = trim(addslashes($this->input->post("college_id")));
        $team_id = trim(addslashes($this->input->post("team_id")));


        $data = array(
            'event_id' => $event_id,
            'team_name' => $team_name,
            'college_id' => $college_id
        );
        $this->User_model->updateTeamDetails($data, $team_id);
        echo 'success~<div class="success-msg">Team details has been updated.</div>';
    }

}

?>