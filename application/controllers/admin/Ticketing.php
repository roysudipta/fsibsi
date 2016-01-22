<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticketing extends FB_Controller {

    public $tblUsers = 'users';
    public $tblTicketCat = 'ticket_category';
    public $tblTicket = 'ticket';
    public $tblTicketReply = 'ticket_reply';

    public function __construct() {
        parent::__construct();
        $this->load->model('Ticketing_model');
        $this->load->model('User_model');
    }

    public function index() {
        $this->load->view('welcome_message');
    }

    public function ticket_category() {
        $data['listofOfficialMembers'] = $this->User_model->listofOfficialMembers();
        $data['ticket_category'] = $this->Ticketing_model->listTicketCategory(array('join' => $this->tblUsers));
        $this->_AdminView(PAGE_ADMIN_TICKET_CATEGORY, $data);
    }

    public function getDetails($id) {

        $data['query'] = $this->Ticketing_model->getTicketCategory($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => array(), 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
        }
    }

    public function saveDetails() {


        if ($this->input->post()) {
            $category_id = $this->input->post('category_id');
            $responsible_person = addslashes($this->input->post('responsible_person'));
            $category_title = addslashes($this->input->post('category_title'));
            $resolve_day = addslashes($this->input->post('resolve_day'));
            $responsible_person_details = $this->User_model->responsible_person_details($responsible_person);
            $listofOfficialMembers = $this->User_model->listofOfficialMembers();
            $slug_alias = $this->convertTitletoSlugAlias($category_title);
            //$checkTitleExistance = $this->Ticketing_model->checkTitleExistance($category_title);
            $checkTitleExistance = $this->Ticketing_model->checkTitleExistance($slug_alias, $category_id);
            if ($category_title == '') {
                echo json_encode(array('success' => false, 'message' => 'Category title can not be blank.', 'data' => array()));
            } elseif ($checkTitleExistance > 0) {

                echo json_encode(array('success' => false, 'message' => 'Category title is already exists.', 'data' => array()));
            } elseif (count($listofOfficialMembers) == 0) {
                echo json_encode(array('success' => false, 'message' => 'There no official person to assign issue related task to be resolved.', 'data' => array()));
            } elseif (count($responsible_person_details) == 0) {
                echo json_encode(array('success' => false, 'message' => 'Please select an official person.', 'data' => array()));
            } elseif ($resolve_day == '') {
                echo json_encode(array('success' => false, 'message' => 'Resolve date can not blank.', 'data' => array()));
            } elseif (is_numeric($resolve_day) == false) {
                echo json_encode(array('success' => false, 'message' => 'Resolve date must be a number.', 'data' => array()));
            } elseif ($resolve_day < 0 || $resolve_day > CONST_ISSUE_MAX_RESOLVE_DAY) {
                echo json_encode(array('success' => false, 'message' => 'Resolve date must be within 0 to ' . CONST_ISSUE_MAX_RESOLVE_DAY . '.', 'data' => array()));
            } else {

                if ($category_id != '') {
                    //echo $slug_alias;die;
                    $data = array(
                        'category_title' => $category_title,
                        'slug_alias'=> $slug_alias,
                        'responsible_person' => $responsible_person,
                        'resolve_day' => $resolve_day
                    );
                    $get_category_details = $this->Ticketing_model->getTicketCategory($category_id);
                    if ($get_category_details['responsible_person'] != $responsible_person) {
                        $query = array
                            (
                            'user_name' => $responsible_person_details['user_name'],
                            'category_title' => $category_title,
                        );
                        $body = $this->load->view(PAGE_ADMIN_TICKET_ISSUE_ASSIGNMENT, $query, TRUE);
                        $this->load->model('mailer');

                        $this->mailer->sendMail(array(
                            'to' => array(
                                'email' => $responsible_person_details['user_email_id'],
                                'name' => 'info@fsi-bsi.com'
                            ),
                            'subject' => 'Issue Assignment',
                            'body' => $body,
                        ));
                    }
                    $this->Ticketing_model->update($data, $category_id);
                    echo json_encode(array('success' => true, 'message' => 'Ticket category details has been successfully updated.', 'data' => array()));
                } else {
                    $data = array(
                        'category_title' => $category_title,
                        'slug_alias'=> $slug_alias,
                        'responsible_person' => $responsible_person,
                        'resolve_day' => $resolve_day
                    );
                    $query = array
                        (
                        'user_name' => $responsible_person_details['user_name'],
                        'category_title' => $category_title,
                    );
                    $body = $this->load->view(PAGE_ADMIN_TICKET_ISSUE_ASSIGNMENT, $query, TRUE);
                    $this->load->model('mailer');

                    $this->mailer->sendMail(array(
                        'to' => array(
                            'email' => $responsible_person_details['user_email_id'],
                            'name' => 'info@fsi-bsi.com'
                        ),
                        'subject' => 'Issue Assignment',
                        'body' => $body,
                    ));
                    $id = $this->Ticketing_model->add($data);
                    $data['query'] = $this->Ticketing_model->getTicketCategory($id);
                    echo json_encode(array('success' => true, 'message' => 'Ticket category details has been successfully uploaded.', 'data' => $data['query']));
                }
            }
        }
    }

    function deleteDetails($id) {
        if ($id !== '') {
            $this->Ticketing_model->delete($id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    function updateStatus($id) {
        if ($id !== '') {
            $details = $this->Ticketing_model->getTicketCategory($id);
            if ($details['status'] == CONST_ACTIVATE) {
                $data = array('status' => CONST_DEACTIVATE);
                $this->Ticketing_model->update($data, $id);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_UPDATE_SUCCESS), 'data' => 'Inactive'));
            } else {
                $data = array('status' => CONST_ACTIVATE);
                $this->Ticketing_model->update($data, $id);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_UPDATE_SUCCESS), 'data' => 'Active'));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    public function open_ticket_listing() {
        $data['listofOfficialMembers'] = $this->User_model->listofOfficialMembers();
        $data['listofTickets'] = $this->Ticketing_model->listofTickets(CONST_ACTIVATE);

        $this->_AdminView(PAGE_ADMIN_OPEN_TICKET_LISTING, $data);
    }

    public function closed_ticket_listing() {
        $data['listofTickets'] = $this->Ticketing_model->listofTickets(CONST_DEACTIVATE);
        $this->_AdminView(PAGE_ADMIN_CLOSED_TICKET_LISTING, $data);
    }

    public function ticketGetDetails($id) {
        $data['query'] = $this->Ticketing_model->getTicketDetails($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => array(), 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
        }
    }

    function updateTicketStatus($ticket_id) {
        if ($ticket_id !== '') {
            $details = $this->Ticketing_model->getTicketDetails($ticket_id);
            if ($details['is_status'] == CONST_ACTIVATE) {
                $data = array('is_status' => CONST_DEACTIVATE);
                $this->Ticketing_model->update_ticket_details($data, $ticket_id);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_CHANGE_STATUS), 'data' => 'Closed'));
            } else {
                $data = array('is_status' => CONST_ACTIVATE);
                $this->Ticketing_model->update_ticket_details($data, $ticket_id);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_CHANGE_STATUS), 'data' => 'Open'));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    public function saveTicketDetails() {


        if ($this->input->post()) {
            $ticket_id = $this->input->post('ticket_id');
            $priority = addslashes($this->input->post('priority'));
            $responsible_person = addslashes($this->input->post('responsible_person'));
            $check_resposible_person_details = $this->User_model->responsible_person_details($responsible_person);

            if ($priority == '') {
                echo json_encode(array('success' => false, 'message' => 'You must select a priority level.', 'data' => array()));
            } elseif ($priority != CONST_PRIORITY_LOW && $priority != CONST_PRIORITY_MEDIUM && $priority != CONST_PRIORITY_HIGH && $priority != CONST_PRIORITY_URGENT) {
                echo json_encode(array('success' => false, 'message' => 'You have selected invalid priority level.', 'data' => array()));
            } elseif (empty($check_resposible_person_details)) {
                echo json_encode(array('success' => false, 'message' => 'Official person does not exists.', 'data' => array()));
            } else {
                
                
                $getTicketDetails = $this->Ticketing_model->getTicketDetails($ticket_id);
                $old_responsible_person  = $getTicketDetails['responsible_person'];
                $data = array('priority' => $priority,'responsible_person'=>$responsible_person);
                $this->Ticketing_model->update_ticket_details($data, $ticket_id);
                $getTicketDetails = $this->Ticketing_model->getTicketDetails($ticket_id);
                if($old_responsible_person!=$responsible_person){
                    $data_value_user = array(
                    'subject' => $getTicketDetails['subject'],
                    'responsible_person' => $getTicketDetails['responsible_person_name'],
                    'responsible_person_email' => $getTicketDetails['responsible_person_email'],
                    'user_name' => $getTicketDetails['user_name'],
                    'purpose' => 'responsible_person_changed_mail_to_user'
                    );
                    $data_value_official = array(
                    'subject' => $getTicketDetails['subject'],
                    'responsible_person' => $getTicketDetails['responsible_person_name'],
                    'responsible_person_email' => $getTicketDetails['responsible_person_email'],
                    'user_name' => $getTicketDetails['user_name'],
                    'purpose' => 'responsible_person_changed_mail_to_official'
                    );
                $body_for_changed_responsible_personTo_user = $this->load->view(PAGE_ADMIN_TICKET_ISSUE_ASSIGNMENT, $data_value_user, TRUE);
                $body_for_changed_responsible_personTo_admin = $this->load->view(PAGE_ADMIN_TICKET_ISSUE_ASSIGNMENT, $data_value_official, TRUE);
                $this->load->model('mailer');

                $this->mailer->sendMail(array(
                    'to' => array(
                        'email' => $getTicketDetails['user_email_id'],
                        'name' => 'info@fsi-bsi.com'
                    ),
                    'subject' => 'Notification of transfer responsible person',
                    'body' => $body_for_changed_responsible_personTo_user,
                ));
                $this->mailer->sendMail(array(
                    'to' => array(
                        'email' => $getTicketDetails['responsible_person_email'],
                        'name' => 'info@fsi-bsi.com'
                    ),
                    'subject' => 'Assignment of ticket Responsiblity',
                    'body' => $body_for_changed_responsible_personTo_admin,
                ));
                }
                
                echo json_encode(array('success' => true, 'message' => 'Ticket priority level has been successfully updated.', 'data' => array()));
            }
        }
    }

    function deleteTicketDetails($ticket_id) {
        if ($ticket_id !== '') {
            $this->Ticketing_model->delete_ticket_details($ticket_id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    public function ticket_reply($ticket_id) {
        $data['TicketDetails'] = $this->Ticketing_model->getTicketDetails($ticket_id);
        $data['listofTicketReplies'] = $this->Ticketing_model->listofTicketReplies($ticket_id);
        $this->_AdminView(PAGE_ADMIN_TICKET_REPLY_LISTING, $data);
    }

    public function post_a_reply() {

        if ($this->input->post()) {
            $reply_content = addslashes($this->input->post('reply_content'));
            $ticket_id = addslashes($this->input->post('ticket_id'));
            $official_only = CONST_DEACTIVATE;
            $userID = $this->session_variable['id'];
            if ($official_only != '') {
                $official_only = $this->input->post('official_only');
            }

            if ($reply_content === '<p><br></p>') {
                echo json_encode(array('success' => false, 'message' => 'Rply field can not be blank.', 'append_content' => array()));
            } elseif ($official_only != '' && $official_only != 1) {
                echo json_encode(array('success' => false, 'message' => 'Invalid Official ckeckbox details.', 'append_content' => array()));
            } else {

                $data = array(
                    'reply_content' => $reply_content,
                    'ticket_id' => $ticket_id,
                    'user_id' => $userID,
                    'official_only' => $official_only
                );
                $reply_id = $this->Ticketing_model->insert_data($data, $this->tblTicketReply);
                $query['reply_details'] = $this->Ticketing_model->getReplyDetails($reply_id);
                //echo $query['reply_details']['subject'];die;
                $getUserDetails = $this->User_model->getUser($query['reply_details']['ticket_user_id']);
                //print_r($getUserDetails['user_name']);die;
                $body = $this->load->view(PAGE_ADMIN_REPLY_CONTENT_APPEND, $query, TRUE);
                $data_reply_post = array(
                    'reply_content' => $reply_content,
                    'ticket_id' => $ticket_id,
                    'user_id' => $userID,
                    'user_name' => $getUserDetails['user_name'],
                    'subject' => $query['reply_details']['subject'],
                    'purpose' => 'reply',
                );
                $body_for_reply_post = $this->load->view(PAGE_ADMIN_TICKET_ISSUE_ASSIGNMENT, $data_reply_post, TRUE);
                $this->load->model('mailer');

                $this->mailer->sendMail(array(
                    'to' => array(
                        'email' => $getUserDetails['user_email_id'],
                        'name' => 'info@fsi-bsi.com'
                    ),
                    'subject' => 'Post a new reply',
                    'body' => $body_for_reply_post,
                ));
                echo json_encode(array('success' => true, 'message' => 'New reply has been successfully posted.', 'append_content' => $body));
            }
        }
    }

    function deleteTicketReplyDetails($reply_id) {
        if ($reply_id !== '') {
            $this->Ticketing_model->delete_details($reply_id, $this->tblTicketReply);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

}
