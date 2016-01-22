<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Issues extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Ticketing_model');
        $logged_page = array('index', '', 'category', 'ticket','post_a_reply','repost_an_issue');
        $pageName = $this->uri->segment(2);

        if (!in_array($pageName, $logged_page)) {
            if ($this->session->userdata('session_user') != '') {
                //$session = $this->session->userdata('session_user');
                $session = $this->session->userdata('session_user');

                $url = '';
                switch ($session['is_type']) {

                    case CONST_USER_ADMIN:
                        $url = base_url() . FN_ADMIN_DASHBOARD;
                        break;
                    case CONST_USER_CAPTAIN:
                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
                        break;
                    case CONST_USER_OFFICIAL:
                        $url = base_url() . FN_OFFICIAL_DASHBOARD;
                        break;
                    case CONST_USER_VICECAPTAIN:
                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
                        break;
                    case CONST_USER_TEAMMEMBER:
                        $url = base_url() . FN_CAPTAIN_DASHBOARD;
                        break;
                    case CONST_USER_FACULTY:
                        $url = base_url() . FNsession_variable_CAPTAIN_DASHBOARD;
                        break;
                }
                redirect($url);
            }
        }
    }

    public $tblTicketCat = 'ticket_category';
    public $tblUsers = 'users';
    public $tblTicket = 'ticket';
    public $tblTicketReply = 'ticket_reply';
    

    public function index() {
        $data['issue_topics'] = $this->Ticketing_model->get_issue_topics(array('where' => $this->tblTicketCat . '.status=' . CONST_ACTIVATE), $this->tblTicketCat);
        $this->_FrontView(PAGE_FRONT_ISSUE_TOPIC, $data);
    }

    public function category($slug_alias) {
        $data['get_id_by_slug_alias'] = $this->Ticketing_model->get_id_by_slug_alias($slug_alias, $this->tblTicketCat);
        //echo '<pre>';print_r($data['issue_listing_under_category'] = $this->Ticketing_model->issue_listing_under_category( $data['get_id_by_slug_alias']['category_id']));echo '</pre>';die;
        $data['issue_listing_under_category'] = $this->Ticketing_model->issue_listing_under_category($data['get_id_by_slug_alias']['category_id']);
        $this->_FrontView(PAGE_FRONT_ISSUE_DETAILS, $data);
    }

    public function ticket($slug_alias) {
        $data['get_id_by_slug_alias'] = $this->Ticketing_model->get_id_by_slug_alias($slug_alias, $this->tblTicket);
        //echo '<pre>';print_r($data['issue_listing_under_category'] = $this->Ticketing_model->issue_listing_under_category( $data['get_id_by_slug_alias']['category_id']));echo '</pre>';die;
        $data['reply_listing_under_ticket'] = $this->Ticketing_model->reply_listing_under_ticket($data['get_id_by_slug_alias']['ticket_id']);
        $this->_FrontView(PAGE_FRONT_ISSUE_REPLY_DETAILS, $data);
    }

    public function post_a_reply() {

        if ($this->input->post()) {
            $reply_content = addslashes($this->input->post('reply_content'));
            $ticket_id = addslashes($this->input->post('ticket_id'));
            //$session = $this->session->userdata('session_user');
            $userID = $this->session_variable['id'];
            if ($reply_content === '<p><br></p>') {
                echo json_encode(array('success' => false, 'message' => 'Rply field can not be blank.', 'append_content' => array()));
            } else {

                $data = array(
                    'reply_content' => $reply_content,
                    'ticket_id' => $ticket_id,
                    'user_id' => $userID
                    
                );
                $reply_id = $this->Ticketing_model->insert_data($data, $this->tblTicketReply);
                $query['reply_details'] = $this->Ticketing_model->getReplyDetails($reply_id);
                $getUserDetails = $this->User_model->getUser($query['reply_details']['ticket_user_id']);
                $body = $this->load->view(PAGE_FRONT_REPLY_CONTENT_APPEND, $query, TRUE);
                $data_reply_post = array(
                    'reply_content' => $reply_content,
                    'ticket_id' => $ticket_id,
                    'user_id' => $userID,
                    'user_name' => $getUserDetails['user_name'],
                    'subject' => $query['reply_details']['subject'],
                    'purpose' => 'reply',
                );
                $body_for_reply_post = $this->load->view(PAGE_FRONT_TICKET_ISSUE_ASSIGNMENT, $data_reply_post, TRUE);
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
    public function repost_an_issue(){
        //print_r($_POST);die;
        if ($this->input->post()) {
            $subject = addslashes($this->input->post('subject'));
            $description = addslashes($this->input->post('description'));
            $category_id = addslashes($this->input->post('category_id'));
            $priority = addslashes($this->input->post('priority'));
            $userID = $this->session_variable['id'];
            $get_category_details = $this->Ticketing_model->getTicketCategory($category_id);
            $slug_alias = $this->convertTitletoSlugAlias($subject);
            $checking_heading_existance = $this->Ticketing_model->checking_heading_existance($slug_alias);
            if($subject =='') {
                echo json_encode(array('success' => false, 'message' => 'Subject can not be blank.', 'append_content' => array()));
            } elseif ($checking_heading_existance>0) {
                echo json_encode(array('success' => false, 'message' => 'Subject is already exists.', 'append_content' => array()));
            } elseif ($priority == '') {
                echo json_encode(array('success' => false, 'message' => 'You must select a priority level.', 'data' => array()));
            } elseif ($description === '<p><br></p>') {
                echo json_encode(array('success' => false, 'message' => 'Description can not be blank.', 'append_content' => array()));
            } else {

                $data = array(
                    'user_id' => $userID,
                    'responsible_person'=> $get_category_details['responsible_person'],
                    'priority'=> $priority,
                    'category_id'=> $category_id,
                    'subject' => $subject,
                    'slug_alias' => $slug_alias,
                    'description' => $description,
                    'is_status' => CONST_ACTIVATE
                );
                $ticket_id = $this->Ticketing_model->insert_data($data, $this->tblTicket);
                $query['ticket_details'] = $this->Ticketing_model->getTicketDetails($ticket_id);
                $getUserDetails = $this->User_model->getUser($get_category_details['responsible_person']);
                $body = $this->load->view(PAGE_FRONT_TICKET_CONTENT_APPEND, $query, TRUE);
                $data_ticket_post = array(
                    'description' => $description,
                    'ticket_id' => $ticket_id,
                    'user_id' => $userID,
                    'user_name' => $getUserDetails['user_name'],
                    'subject' => $query['ticket_details']['subject'],
                    'purpose' => 'Report_an_Issue',
                );
                $body_for_ticket_post = $this->load->view(PAGE_FRONT_TICKET_ISSUE_ASSIGNMENT, $data_ticket_post, TRUE);
                $this->load->model('mailer');
//echo $getUserDetails['user_email_id'];die;
                $this->mailer->sendMail(array(
                    'to' => array(
                        'email' => $getUserDetails['user_email_id'],
                        'name' => 'info@fsi-bsi.com'
                    ),
                    'subject' => 'Report an Issue',
                    'body' => $body_for_ticket_post,
                ));
                echo json_encode(array('success' => true, 'message' => 'New report ticket has been successfully posted.', 'append_content' => $body));
            }
        }
    }

}
