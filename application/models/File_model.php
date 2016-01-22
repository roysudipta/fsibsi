<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblSubmissionType = 'submissions_type';
    public $tblEvent = 'events';
    public $tblDeadLine = 'deadlines';

    public function listFileTypes($parent_category = NULL) {

        $query = $this->db->select(
                        array(
                            $this->tblSubmissionType . '.*',
                            'tblParentCategory.caption as Parent_cat_caption',
                            $this->tblEvent.'.event_name',
                            $this->tblDeadLine.'.title'
                        )
                )
                ->join($this->tblEvent, $this->tblEvent.'.id='.$this->tblSubmissionType.'.event_id')
                ->join($this->tblDeadLine, $this->tblDeadLine.'.id='.$this->tblSubmissionType.'.deadline','left')
                ->join($this->tblSubmissionType . ' as tblParentCategory', $this->tblSubmissionType . '.parent_category = tblParentCategory.id ', 'left ')
                ->get($this->tblSubmissionType);

        //echo $this->db->last_query();exit;
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function category_or_file_type_lists($data = NULL) {
        $query = $this->db->get_where($this->tblSubmissionType, array($this->tblSubmissionType . '.is_category' => $data));
        return $query->result_array();
    }

    function getFilePropByID($id) {
        $query = $this->db->get_where($this->tblSubmissionType, array($this->tblSubmissionType . '.id' => $id));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function check_file_category_existance($caption, $id = NULL,$event_id=NULL) {
        if ($id == NULL) {
            $query = $this->db->select(array($this->tblSubmissionType . '.id'))
                    ->get_where($this->tblSubmissionType, array($this->tblSubmissionType . '.caption' => $caption, $this->tblSubmissionType . '.is_category' => CONST_DEACTIVATE, $this->tblSubmissionType.'.event_id'=>$event_id));
        } else {
            $query = $this->db->select(array($this->tblSubmissionType . '.id'))
                    ->get_where($this->tblSubmissionType, array($this->tblSubmissionType . '.caption' => $caption, $this->tblSubmissionType . '.id!=' => $id, $this->tblSubmissionType . '.is_category' => CONST_DEACTIVATE, $this->tblSubmissionType.'.event_id'=>$event_id));
        }
        
        return $query->num_rows();
    }

    public function insert_data($data, $table) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_details($data, $id, $table) {
        $this->db->update($table, $data, array('id' => $id));
    }

    public function delete_details($id, $table) {
        $this->db->delete($table, array('id' => $id));
    }

    public function fatch_category_by_event_id($event_id) {

        $query = $this->db->select(array($this->tblSubmissionType . '.caption', $this->tblSubmissionType . '.id'))
                ->get_where($this->tblSubmissionType, array($this->tblSubmissionType . '.event_id' => $event_id, $this->tblSubmissionType . '.is_category' => CONST_DEACTIVATE));
        //return $this->db->last_query();
        return $query->result_array();
    }
    public function fatch_deadline_by_event_id($event_id) {

        $query = $this->db->select(array($this->tblDeadLine . '.*'))
                ->get_where($this->tblDeadLine, array($this->tblDeadLine . '.event_id' => $event_id));
        //return $this->db->last_query();
        return $query->result_array();
    }

}
