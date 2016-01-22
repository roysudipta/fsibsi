<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Submission extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
        $this->load->model('File_model');
    }

    public $tblSubmissionType = 'submissions_type';

    public function FileTypes() {
        $data['ListEvent'] = $this->Event_model->listEvents(array('where' => 'is_ongoing="' . CONST_ACTIVATE . '"'));
        $data['category_or_file_type_lists'] = $this->File_model->category_or_file_type_lists(CONST_DEACTIVATE);
        $data['file_types'] = $this->File_model->listFileTypes();
        $this->_AdminView(PAGE_ADMIN_FILE_TYPES, $data);
    }

    function GetFileType($id) {
        $data = $this->File_model->getFilePropByID($id);
        echo json_encode(array('success' => true, 'message' => 'Success', 'data' => $data));
    }

    public function saveDetails() {
        if ($this->input->post()) {

            $id = $this->input->post('id');
            $type = $this->input->post('type');
            $event_id = $this->input->post('event_id');
            $caption = addslashes($this->input->post('caption'));
            $file_description = addslashes($this->input->post('description'));


            if ($type == CONST_ACTIVATE) {
                $parent_category = $this->input->post('parent_category');
                $file_type = $this->input->post('file_type');
                $file_type_text = $this->input->post('file_type_text');
                $file_size_limit = addslashes($this->input->post('file_size_limit'));
                $file_extensions = CONST_ALLOWED_EXTENSIONS;
                $check_file_category_existance = $this->File_model->check_file_category_existance($caption, $id,$event_id);
                $tmp_extensions = explode('|', $file_extensions);
                if ($event_id == '') {
                    echo json_encode(array('success' => false, 'message' => 'Please choose an event.', 'data' => array()));
                } elseif ($caption == '') {
                    echo json_encode(array('success' => false, 'message' => 'Caption can not be blank.', 'data' => array()));
                } elseif ($parent_category == '') {
                    echo json_encode(array('success' => false, 'message' => 'Please choose one of the category.', 'data' => array()));
                } elseif ($check_file_category_existance > 0) {
                    echo json_encode(array('success' => false, 'message' => 'File category is already exists.', 'data' => array()));
                } elseif ($file_type_text === 'null') {
                    echo json_encode(array('success' => false, 'message' => 'File type can not be blank.', 'data' => array()));
                } elseif ($file_size_limit == '' || $file_size_limit > CONST_MAX_FILE_UPLOAD_SIZE) {
                    echo json_encode(array('success' => false, 'message' => 'File size can not be blank and file size must be less than ' . CONST_MAX_FILE_UPLOAD_SIZE . 'Kb.', 'data' => array()));
                } else {


                    if ($id == '') {
                        $data = array(
                            'event_id' => $event_id,
                            'is_category' => $type,
                            'caption' => $caption,
                            'parent_category' => $parent_category,
                            'file_type' => $file_type_text,
                            'file_size_limit' => $file_size_limit,
                            'file_description' => $file_description,
                            'deadline' => NULL,
                        );
                        $this->File_model->insert_data($data, $this->tblSubmissionType);
                        echo json_encode(array('success' => true, 'message' => 'File type has been successfully uploaded.', 'data' => array()));
                    } else {
                        $data = array(
                            'event_id' => $event_id,
                            //'is_category' => $type,
                            'caption' => $caption,
                            'parent_category' => $parent_category,
                            'file_type' => $file_type_text,
                            'file_size_limit' => $file_size_limit,
                            'file_description' => $file_description,
                            'deadline' => NULL,
                        );
                        $this->File_model->update_details($data, $id, $this->tblSubmissionType);
                        echo json_encode(array('success' => true, 'message' => 'File type has been successfully updated.', 'data' => array()));
                    }
                }
            } else {

                $deadline = $this->input->post('deadline');
                $check_file_category_existance = $this->File_model->check_file_category_existance($caption, $id,$event_id);
                if ($event_id == '') {
                    echo json_encode(array('success' => false, 'message' => 'Please choose an event.', 'data' => array()));
                } elseif ($caption == '') {
                    echo json_encode(array('success' => false, 'message' => 'Caption can not be blank.', 'data' => array()));
                } elseif ($check_file_category_existance > 0) {
                    echo json_encode(array('success' => false, 'message' => 'File category is already exists.', 'data' => array()));
                } elseif ($deadline == '') {
                    echo json_encode(array('success' => false, 'message' => 'Please choose a dead line for your file category.', 'data' => array()));
                } else {


                    if ($id == '') {
                        $data = array(
                            'event_id' => $event_id,
                            'is_category' => $type,
                            'caption' => $caption,
                            'parent_category' => 0,
                            'deadline' => $deadline,
                            'file_description' => $file_description,
                            'file_type' => '',
                            'file_size_limit' => ''
                        );
                        $this->File_model->insert_data($data, $this->tblSubmissionType);
                        echo json_encode(array('success' => true, 'message' => 'Category has been successfully uploaded.', 'data' => array()));
                    } else {
                        $data = array(
                            'event_id' => $event_id,
                            //'is_category' => $type,
                            'caption' => $caption,
                            //'parent_category' => 0,
                            'deadline' => $deadline,
                            'file_description' => $file_description,
                            'file_type' => '',
                            'file_size_limit' => ''
                        );
                        $this->File_model->update_details($data, $id, $this->tblSubmissionType);
                        echo json_encode(array('success' => true, 'message' => 'Category has been successfully updated.', 'data' => array()));
                    }
                }
            }
        }
    }

    function updateStatus($id) {
        if ($id !== '') {
            $details = $this->File_model->getFilePropByID($id);
            if ($details['is_status'] == CONST_ACTIVATE) {
                $data = array('is_status' => CONST_DEACTIVATE);
                $this->File_model->update_details($data, $id, $this->tblSubmissionType);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_CHANGE_STATUS), 'data' => 'Inactive'));
            } else {
                $data = array('is_status' => CONST_ACTIVATE);
                $this->File_model->update_details($data, $id, $this->tblSubmissionType);
                echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_CHANGE_STATUS), 'data' => 'Active'));
            }
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    function deleteDetails($id) {
        if ($id !== '') {
            $this->File_model->delete_details($id, $this->tblSubmissionType);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

    public function fatchCategory() {
        $event_id = $this->input->post('event_id');
        $fatch_category_by_event_id = $this->File_model->fatch_category_by_event_id($event_id);
        $fatch_deadline_by_event_id = $this->File_model->fatch_deadline_by_event_id($event_id);
//        echo '<select class="form-control select2me" data-placeholder="Select..." name="parent_category" id="parent_category" >';
        $tmpDataCat =$tmpDataDeadline ='<option value="">Choose one</option>';
        
        if (count($fatch_category_by_event_id) > 0) {

            foreach ($fatch_category_by_event_id as $row) {

                $tmpDataCat .= '<option value="'.$row["id"].'">'. stripslashes($row['caption']).'</option>';
                
            }
        } 
        if (count($fatch_deadline_by_event_id) > 0) {

            foreach ($fatch_deadline_by_event_id as $row1) {

                $tmpDataDeadline .= '<option value="'.$row1["id"].'">'. stripslashes($row1['title']).'</option>';
                
            }
        } 
        
        echo json_encode(array('success' => TRUE, 'category' =>$tmpDataCat ,'deadline'=>$tmpDataDeadline));
    }

}
