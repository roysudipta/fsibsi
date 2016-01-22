<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class College_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblColleges = 'participant_college';

    public function listColleges($param = array()) {
        if (array_key_exists('select', $param)) {
            $this->db->select($param['select']);
        }
        if (array_key_exists('where', $param)) {
            $this->db->where($param['where']);
        }
        if (array_key_exists('join', $param)) {
            $this->db->join($param['join']);
        }
        if (array_key_exists('order_by', $param)) {
            $this->db->order_by($param['order_by']);
        }



        $query = $this->db->get($this->tblColleges);

        return $query->result_array();
    }

    public function getCollege($id) {
        $query = $this->db->select(array($this->tblColleges . '.*'))
                ->get_where($this->tblColleges, array($this->tblColleges . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function update($data, $id) {
        $query = $this->db->update($this->tblColleges, $data, array('id' => $id));
        if ($query == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add($data) {
        $this->db->insert($this->tblColleges, $data);
        return $this->db->insert_id();
    }

    public function changeStatus($id, $status) {
        $this->db->update($this->tblColleges, array('is_status' => $status), array('id' => $id));
    }

    public function delete($id) {
        $this->db->delete($this->tblColleges, array('id' => $id));
    }

}
