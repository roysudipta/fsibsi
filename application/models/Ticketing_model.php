<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ticketing_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblTicketCat = 'ticket_category';
    public $tblUsers = 'users';
    public $tblTicket = 'ticket';
    public $tblTicketReply = 'ticket_reply';

    public function listTicketCategory($param = array()) {
//        echo $param['join'];exit;
        if (array_key_exists('select', $param)) {
            $this->db->select($param['select']);
        }
        if (array_key_exists('where', $param)) {
            $this->db->where($param['where']);
        }
        if (array_key_exists('join', $param)) {
            switch ($param['join']) {
                case $this->tblUsers :
                    $this->db->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicketCat . '.responsible_person');
                    break;
            }
        }

        $query = $this->db->get($this->tblTicketCat);
        //return $this->db->last_query();
        return $query->result_array();
    }

    public function getTicketCategory($id) {
        $query = $this->db->select(array($this->tblTicketCat . '.*'))
                ->get_where($this->tblTicketCat, array($this->tblTicketCat . '.category_id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function update($data, $id) {
        $this->db->update($this->tblTicketCat, $data, array('category_id' => $id));
        #echo $this->db->last_query();exit;
    }

    public function add($data) {
        $this->db->insert($this->tblTicketCat, $data);
        return $this->db->insert_id();
    }

    public function changeStatus($id, $status) {
        $this->db->update($this->tblNews, array('is_status' => $status), array('id' => $id));
    }

    public function delete($id) {
        $this->db->delete($this->tblTicketCat, array('category_id' => $id));
    }

    public function checkTitleExistance($slug_alias, $category_id = NULL) {
        if ($category_id == NULL) {
            $query = $this->db->get_where($this->tblTicketCat, array('slug_alias' => $slug_alias));
        } else {
            $query = $this->db->get_where($this->tblTicketCat, array('slug_alias' => $slug_alias, 'category_id !=' => $category_id));
        }
        return $query->num_rows();
    }

    public function listofTickets($is_status) {
        $query = $this->db->select(
                        array($this->tblTicket . '.*',
                            $this->tblUsers . '.user_email_id',
                            $this->tblUsers . '.user_name',
                            'tblResponsiblePerson.user_name as responsible_person',
                            'tblResponsiblePerson.user_email_id as responsible_person_email',
                            $this->tblTicketCat . '.category_title')
                )
                ->join($this->tblTicketCat, $this->tblTicketCat . '.category_id = ' . $this->tblTicket . '.category_id')
                ->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicket . '.user_id')
                ->join($this->tblUsers . ' as tblResponsiblePerson', 'tblResponsiblePerson.id = ' . $this->tblTicket . '.responsible_person')
                ->get_where($this->tblTicket, array($this->tblTicket . '.is_status' => $is_status));
        //echo $this->db->last_query();
        return $query->result_array();
    }

    public function getTicketDetails($ticket_id) {
        $query = $this->db->select(array(
                    $this->tblTicket . '.*',
                    $this->tblTicketCat . '.category_title',
                    $this->tblUsers . '.user_name',
                    $this->tblUsers . '.user_email_id',
                    $this->tblUsers . '.img_profile',
                    'tblResponsiblePerson.user_name as responsible_person_name',
                    'tblResponsiblePerson.user_email_id as responsible_person_email',
                ))
                ->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicket . '.user_id')
                ->join($this->tblTicketCat, $this->tblTicketCat . '.category_id = ' . $this->tblTicket . '.category_id')
                ->join($this->tblUsers . ' as tblResponsiblePerson', 'tblResponsiblePerson.id = ' . $this->tblTicket . '.responsible_person')
                ->get_where($this->tblTicket, array($this->tblTicket . '.ticket_id' => $ticket_id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function update_ticket_details($data, $ticket_id) {
        $this->db->update($this->tblTicket, $data, array('ticket_id' => $ticket_id));
        #echo $this->db->last_query();exit;
    }

    public function delete_ticket_details($ticket_id) {
        $this->db->delete($this->tblTicket, array('ticket_id' => $ticket_id));
    }

    public function listofTicketReplies($ticket_id) {
        $query = $this->db->select(array(
                    $this->tblTicketReply . '.reply_id',
                    $this->tblTicketReply . '.reply_content',
                    $this->tblTicketReply . '.reply_image_file',
                    $this->tblTicketReply . '.is_status as reply_status',
                    $this->tblTicketReply . '.created as reply_created_date',
                    $this->tblTicketCat . '.category_title',
                    $this->tblUsers . '.user_name',
                    $this->tblUsers . '.user_email_id',
                    $this->tblUsers . '.img_profile',
                    $this->tblTicket . '.*'))
                ->order_by($this->tblTicketReply . '.reply_id', 'ASC')
                ->join($this->tblTicket, $this->tblTicket . '.ticket_id = ' . $this->tblTicketReply . '.ticket_id')
                ->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicketReply . '.user_id')
                ->join($this->tblTicketCat, $this->tblTicketCat . '.category_id = ' . $this->tblTicket . '.category_id')
                ->get_where($this->tblTicketReply, array($this->tblTicketReply . '.ticket_id' => $ticket_id));
        return $query->result_array();
    }

    public function insert_data($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function getReplyDetails($reply_id) {
        $query = $this->db->select(array(
                    $this->tblTicketReply . '.*',
                    $this->tblUsers . '.user_name',
                    $this->tblUsers . '.user_email_id',
                    $this->tblUsers . '.img_profile',
                    $this->tblTicket . '.subject',
                    $this->tblTicket . '.user_id as ticket_user_id'
                ))
                ->order_by($this->tblTicketReply . '.reply_id', 'ASC')
                ->join($this->tblTicket, $this->tblTicket . '.ticket_id = ' . $this->tblTicketReply . '.ticket_id')
                ->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicketReply . '.user_id')
                ->get_where($this->tblTicketReply, array('reply_id' => $reply_id));
        return $query->row_array();
        //return $this->db->last_query();
    }

    public function delete_details($id, $table) {
        $this->db->delete($table, array('reply_id' => $id));
    }

    /*
     * Front END Start
     */
    /*
     * Author   : Arijit Chandra
     * Purpose  : Get Total Number Of Active ISSUE Topics 
     * Param    : NONE except default
     */

    public function get_issue_topics($param = array(), $table) {
//        echo $param['join'];exit;
        if (array_key_exists('select', $param)) {
            $this->db->select($param['select']);
        }
        if (array_key_exists('where', $param)) {
            $this->db->where($param['where']);
        }
        if (array_key_exists('join', $param)) {
            $this->db->join($param['join']);
        }

        $query = $this->db->get($table);
        //return $this->db->last_query();
        return $query->result_array();
    }

    /*
     * Author   : Arijit Chandra
     * Purpose  : Get Issue Category ID by Slug alias 
     * Param    : NONE except default
     */

    public function get_id_by_slug_alias($slug_alias, $table) {
        $query = $this->db->select(array($table . '.*'))
                ->get_where($table, array($table . '.slug_alias' => $slug_alias));
        return $query->row_array();
    }
    /*
     * Author   : Arijit Chandra
     * Purpose  : Get all issues under one category 
     * Param    : NONE except default
    */
    public function issue_listing_under_category($category_id) {
        $query = $this->db->select(
                        array($this->tblTicket . '.*',
                            $this->tblUsers . '.user_email_id',
                            $this->tblUsers . '.user_name',
                            $this->tblUsers . '.img_profile',
                            'tblResponsiblePerson.user_name as responsible_person',
                            'tblResponsiblePerson.user_email_id as responsible_person_email',
                            )
                )
                
                ->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicket . '.user_id')
                ->join($this->tblUsers . ' as tblResponsiblePerson', 'tblResponsiblePerson.id = ' . $this->tblTicket . '.responsible_person')
                ->get_where($this->tblTicket, array( $this->tblTicket . '.category_id' => $category_id));
        //echo $this->db->last_query();
        return $query->result_array();
    }
    /*
     * Author   : Arijit Chandra
     * Purpose  : Get all replies under one ticket 
     * Param    : NONE except default
    */
    public function reply_listing_under_ticket($ticket_id) {
        $query = $this->db->select(array(
                    $this->tblTicketReply . '.*',
                    $this->tblUsers . '.user_name',
                    $this->tblUsers . '.user_email_id',
                    $this->tblUsers . '.img_profile',
                    //$this->tblTicket . '.*'
                    ))
                ->order_by($this->tblTicketReply . '.reply_id', 'ASC')
                ->join($this->tblTicket, $this->tblTicket . '.ticket_id = ' . $this->tblTicketReply . '.ticket_id')
                ->join($this->tblUsers, $this->tblUsers . '.id = ' . $this->tblTicketReply . '.user_id')
                
                ->get_where($this->tblTicketReply, array($this->tblTicketReply . '.ticket_id' => $ticket_id,  $this->tblTicketReply.'.is_status'=>CONST_ACTIVATE));
        //echo $this->db->last_query();die;
        return $query->result_array();
    }
    /*
     * Author   : Arijit Chandra
     * Purpose  : Checking ticket heading existance 
     * Param    : NONE except default
    */
    public function checking_heading_existance($slug_alias) {
        $query = $this->db->get_where($this->tblTicket, array('slug_alias' => $slug_alias));
        return $query->num_rows();
    }

    
    

}
