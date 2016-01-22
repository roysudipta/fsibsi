<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Deadline_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblDeadline = 'deadlines';

    public function listEvents($param = array()) {
        if (array_key_exists('select', $param)) {
            $this->db->select($param['select']);
        }
        if (array_key_exists('where', $param)) {
            $this->db->where($param['where']);
        }
        if (array_key_exists('join', $param)) {
            $this->db->join($param['join']);
        }

        $query = $this->db->get($this->tblDeadline);
    //return $this->db->last_query();exit;
        return $query->result_array();
    }

    public function getdeadlineDetails($id) {
        $query = $this->db->select(array($this->tblDeadline . '.*'))
                ->get_where($this->tblDeadline, array($this->tblDeadline . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function update($data, $id) {
        $this->db->update($this->tblDeadline, $data, array('id' => $id));
        #echo $this->db->last_query();exit;
    }

    public function add($data) {
        $this->db->insert($this->tblDeadline, $data);
        return $this->db->insert_id();
    }

    

}
