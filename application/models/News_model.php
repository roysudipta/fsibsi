<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblNews = 'cms_public_relations';
    public $tblEvents = 'events';

    public function listNews() {
        $query = $this->db->select(array($this->tblNews . '.* ', $this->tblEvents . '.id as eventID', $this->tblEvents . '.event_name'))
                ->join($this->tblEvents, $this->tblEvents . '.id = ' . $this->tblNews . '.event_id')
                ->get_where($this->tblNews);



        return $query->result_array();
    }

    public function getNews($id) {
        $query = $this->db->select(array($this->tblNews . '.* ', $this->tblEvents . '.id as eventID', $this->tblEvents . '.event_name'))
                ->join($this->tblEvents, $this->tblEvents . '.id = ' . $this->tblNews . '.event_id')
                ->get_where($this->tblNews, array($this->tblNews . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function update($data, $id) {
        $this->db->update($this->tblNews, $data, array('id' => $id));
        #echo $this->db->last_query();exit;
    }

    public function add($data) {
        $this->db->insert($this->tblNews, $data);
        return $this->db->insert_id();
    }

    public function changeStatus($id, $status) {
        $this->db->update($this->tblNews, array('is_status' => $status), array('id' => $id));
    }

    public function delete($id) {
        $this->db->delete($this->tblNews, array('id' => $id));
    }

    public function check_heading_existance($heading, $event_id, $id = NULL) {
        if ($id == NULL) {
            $query = $this->db->get_where($this->tblNews, array($this->tblNews . '.heading'=> $heading, $this->tblNews . '.event_id'=> $event_id));
        } else {
            $query = $this->db->get_where($this->tblNews, array($this->tblNews . '.heading'=> $heading, $this->tblNews . '.event_id'=> $event_id,  $this->tblNews.'.id!='=> $id));
        }
        return $query->num_rows();
        //return $this->db->last_query();
    }

}
