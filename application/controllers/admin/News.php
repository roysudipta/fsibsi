<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class News extends FB_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('User_model');
    }

    public function index() {
        $data['ListEvent'] = $this->User_model->ListEvent();
        $data['news'] = $this->News_model->listNews();
        $this->_AdminView(PAGE_ADMIN_NEWS, $data);
    }

    public function getDetails($id) {

        $data['query'] = $this->News_model->getNews($id);

        if (!empty($data['query'])) {
            echo json_encode(array('success' => true, 'message' => array(), 'data' => $data['query']));
        } else {
            echo json_encode(array('success' => false, 'message' => $this->lang->line(MSG_ERR_NO_DATA), 'data' => array()));
        }
    }

    

    public function saveDetails() {
        $img_file = $_FILES["img_file"]["name"];
        $img_size = $_FILES["img_file"]["size"];
        $img_type = $_FILES["img_file"]["type"];
        $validextensions = array("jpeg", "jpg", "png", "gif");
        $temporary = explode(".", $img_file);
        $file_extension = end($temporary);

        $width = $this->input->post("width");
        $height = $this->input->post("height");

        if ($this->input->post()) {
            $id = $this->input->post('news_id');
            $is_type = $this->input->post('is_type');
            $heading = addslashes($this->input->post('heading'));
            $event_id = addslashes($this->input->post('event_id'));
            $news_description = addslashes($this->input->post('news_description'));
            $slug_alias = $this->convertTitletoSlugAlias($heading);
            $check_heading_existance = $this->News_model->check_heading_existance($heading, $event_id,$id);
            if ($is_type == '') {
                echo json_encode(array('success' => false, 'message' => 'Please select a News type.', 'data' => array()));
            } elseif ($is_type != CONST_PR_NEWS && $is_type != CONST_PR_ACHIEVEMENT && $is_type != CONST_PR_PRESS_RELEASE && $is_type != CONST_PR_EVENT) {
                echo json_encode(array('success' => false, 'message' => 'News type is not valid.', 'data' => array()));
            } elseif ($event_id == '') {
                echo json_encode(array('success' => false, 'message' => 'Please select an event.', 'data' => array()));
            } elseif ($heading == '') {
                echo json_encode(array('success' => false, 'message' => 'News heading can not be blank.', 'data' => array()));
            } elseif ($check_heading_existance>0) {
                echo json_encode(array('success' => false, 'message' => 'News heading is already exists.', 'data' => array()));
            } else {

                if ($id != '') {
                    $news_details = $this->News_model->getNews($id);
                    if ($img_file == '') {
                        if ($news_description == '') {
                            echo json_encode(array('success' => false, 'message' => 'News description can not be blank.', 'data' => array()));
                        } else {
                            $data = array(
                                'heading' => $heading,
                                'slug_alias'=> $slug_alias,
                                'news_description' => $news_description,
                                'is_type' => $is_type,
                                'event_id' => $event_id,
                                'is_status' => CONST_ACTIVATE
                            );
                            $this->News_model->update($data, $id);
                            echo json_encode(array('success' => true, 'message' => 'News details has been successfully uploaded.', 'data' => array()));
                        }
                    } else {
                        if ($img_file == '') {
                            echo json_encode(array('success' => false, 'message' => 'Please upload a picture.', 'data' => array()));
                        } elseif (($img_type != "image/png" || $img_type != "image/jpg" || $img_type != "image/jpeg" || $img_type != "image/gif") && $img_size > 100000 && !in_array($file_extension, $validextensions)) {
                            echo json_encode(array('success' => false, 'message' => 'Uploaded picture must be in jpg,jpeg,png format and less than 10MB.', 'data' => array()));
                        } elseif ($width > USER_NEWS_IMAGE_WIDTH_MAX || $height > USER_NEWS_IMAGE_HEIGHT_MAX) {
                            echo json_encode(array('success' => false, 'message' => 'Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be less than or equal ' . USER_NEWS_IMAGE_WIDTH_MAX . 'X' . USER_NEWS_IMAGE_HEIGHT_MAX . '.', 'data' => array()));
                        } elseif ($width < USER_NEWS_IMAGE_WIDTH_MIN || $height < USER_NEWS_IMAGE_HEIGHT_MIN) {
                            echo json_encode(array('success' => false, 'message' => 'Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be greater than or equal ' . USER_NEWS_IMAGE_WIDTH_MIN . 'X' . USER_NEWS_IMAGE_HEIGHT_MIN . '.', 'data' => array()));
                        } elseif ($news_description == '') {
                            echo json_encode(array('success' => false, 'message' => 'News description can not be blank.', 'data' => array()));
                        } else {

                            $filename = md5(time()) . '_' . $img_file;
                            move_uploaded_file($_FILES["img_file"]["tmp_name"], CONST_PATH_NEWS_IMAGE . $filename);

                            unlink(CONST_PATH_NEWS_IMAGE . $news_details['img_file']);
                            $data = array(
                                'heading' => $heading,
                                'slug_alias'=> $slug_alias,
                                'img_file' => $filename,
                                'news_description' => $news_description,
                                'is_type' => $is_type,
                                'event_id' => $event_id,
                                'is_status' => CONST_ACTIVATE
                            );
                            $this->News_model->update($data, $id);
                            echo json_encode(array('success' => true, 'message' => 'News details has been successfully uploaded.', 'data' => array('img_file' => $filename)));
                        }
                    }
                } else {

                    if ($img_file == '') {
                        echo json_encode(array('success' => false, 'message' => 'Please upload a picture.', 'data' => array()));
                    } elseif (($img_type != "image/png" || $img_type != "image/jpg" || $img_type != "image/jpeg" || $img_type != "image/gif") && $img_size > 100000 && !in_array($file_extension, $validextensions)) {
                        echo json_encode(array('success' => false, 'message' => 'Uploaded picture must be in jpg,jpeg,png format and less than 10MB.', 'data' => array()));
                    } elseif ($width > USER_NEWS_IMAGE_WIDTH_MAX || $height > USER_NEWS_IMAGE_HEIGHT_MAX) {
                        echo json_encode(array('success' => false, 'message' => 'Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be less than or equal ' . USER_NEWS_IMAGE_WIDTH_MAX . 'X' . USER_NEWS_IMAGE_HEIGHT_MAX . '.', 'data' => array()));
                    } elseif ($width < USER_NEWS_IMAGE_WIDTH_MIN || $height < USER_NEWS_IMAGE_HEIGHT_MIN) {
                        echo json_encode(array('success' => false, 'message' => 'Uploaded image resolution is ' . $width . 'X' . $height . ' and it must be greater than or equal ' . USER_NEWS_IMAGE_WIDTH_MIN . 'X' . USER_NEWS_IMAGE_HEIGHT_MIN . '.', 'data' => array()));
                    } elseif ($news_description == '') {
                        echo json_encode(array('success' => false, 'message' => 'News description can not be blank.', 'data' => array()));
                    } else {
                        $filename = md5(time()) . '_' . $img_file;
                        move_uploaded_file($_FILES["img_file"]["tmp_name"], CONST_PATH_NEWS_IMAGE . $filename);
                        $data = array(
                            'heading' => $heading,
                            'slug_alias'=> $slug_alias,
                            'img_file' => $filename,
                            'news_description' => $news_description,
                            'is_type' => $is_type,
                            'event_id' => $event_id,
                            'is_status' => CONST_ACTIVATE
                        );
                        $id = $this->News_model->add($data);
                        $data['query'] = $this->News_model->getNews($id);
                        echo json_encode(array('success' => true, 'message' => 'News details has been successfully updated.', 'data' => $data['query']));
                    }
                }
            }
        }
    }

    function deleteDetails($id) {
        if ($id !== '') {
            $this->News_model->delete($id);
            echo json_encode(array('success' => TRUE, 'message' => $this->lang->line(MSG_SCS_DELETED_SUCCESS)));
        } else {
            echo json_encode(array('success' => FALSE, 'message' => $this->lang->line(MSG_ERR_AJAX_CALL_FAILS)));
        }
    }

}
