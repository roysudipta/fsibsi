<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblGallery = 'gallery';

    public function getAllChildElement($main_event, $parent_id = NULL, $is_type = NULL) {
        if ($is_type != NULL) {
            $this->db->where(array('is_type' => $is_type));
        }
        if ($parent_id != NULL) {
            $this->db->where(array('parent_id' => $parent_id));
        }
        $query = $this->db->order_by('image_order', 'asc')->get_where($this->tblGallery, array('main_event' => $main_event)) ;
                       
        return $query->result_array();
    }

    public function getParentByChildID($main_event, $id) {
        $query = $this->db->join($this->tblGallery . 'as Parent', 'Parent.id = ' . $this->tblGallery . '.parent_id')
                ->order_by('image_order', 'asc')->get_where($this->tblGallery, array('main_event' => $main_event, 'id' => $id));
        return $query->result_array();
    }
    public function get_album_details($id)
    {
        $query = $this->db->get_where($this->tblGallery, array('id' => $id));
        return $query->row_array();
    }
    public function get_photo_details($id)
    {
        $query = $this->db->get_where($this->tblGallery, array('id' => $id));
        return $query->row_array();
    }
    public function child_album_details($id)
    {
        $query = $this->db->get_where($this->tblGallery, array('parent_id' => $id));
        return $query->num_rows(); 
    }
    public function getMaxLevel($main_event) {
        $query = $this->db->select_max('level')
                ->get_where($this->tblGallery,array('main_event'=>$main_event,'is_type'=>CONST_GALLERY_TYPE_ALBUM));
        return $query->row_array();        
              
    }
    public function isAlbumNameExists($main_event,$level,$display_name) {
        $query = $this->db->get_where($this->tblGallery, array('main_event' => $main_event,'level'=>$level,'display_name'=>$display_name));
        return $query->num_rows();  
              
    }
    public function insert_new_album($data) {
        $this->db->insert($this->tblGallery, $data);
        return $this->db->insert_id();

              
    }
    public function delete_album($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tblGallery);

    }

    public function delete_image($id) {
        $this->db->where("id", $id);
        $this->db->delete($this->tblGallery);

    }
    public function get_max_order($parent_id)
    {
        $query = $this->db->select_max('image_order')->get_where($this->tblGallery, array('parent_id' => $parent_id,'is_type'=>CONST_GALLERY_TYPE_PHOTO));
        return $query->row_array(); 
    }
    public function update_image_order($data) {
        $tmp_array = explode('=', $data);
      
        $this->db->update($this->tblGallery, array('image_order'=>$tmp_array[1]), array('id' => $tmp_array[0]));
       
    }


}
