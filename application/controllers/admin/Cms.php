<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends FB_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model('cms_model');
    }

    public $tbl_article = 'cms_articles';

    public function index() {
        $data['articles'] = $this->cms_model->listArticles();
        $this->_AdminView(PAGE_ADMIN_CMS_ARTICLE_LIST, $data);
    }

    function UpdateArticle($id) {

        $data['page_category'] = $this->cms_model->getPageCategory();
        $data['article'] = $this->cms_model->getArticle($id);

        $content['page_content'] = $this->load->view(PAGE_CMS, $data, TRUE);
        $this->load->view(PAGE_DASHBOARD, $content);
    }

    function NewAticle() {

        If ($this->input->post('submit')) {

            $id = $this->input->post('article_id');

            $data = array('article_title' => $this->input->post('page_title'),
                'article_slug' => $this->input->post('page_url'),
                'article_content' => $this->input->post('content'),
                'article_status' => $this->input->post('publish'),
                'article_type' => $this->input->post('article_type'),
                'article_sub_category' => $this->input->post('child_category_id'),
                'article_parent_id' => $this->input->post('article_parent_id'),
                'article_banner_yn' => $this->input->post('article_banner_yn'),
                'seo_focus_key_word' => $this->input->post('focus_key_word'),
                'seo_snippest' => $this->input->post('seo_title'),
                'seo_meta' => $this->input->post('meta_description'));

            if ($id != '') {
                $this->cms_model->updateArticle($data, $id);
            } else {
                $this->cms_model->saveArticle($data);
            }
        }
    }

    function social() {

        if ($this->input->post('submit')) {

            $data = array(
                'fb_link' => $this->input->post('fb_link'),
                'google_link' => $this->input->post('google_link'),
                'linked_in_link' => $this->input->post('linked_in_link'),
                'twitter_link' => $this->input->post('twitter_link'),
                'pinterest_link' => $this->input->post('pinterest_link'),
                'flicker_link' => $this->input->post('flicker_link'));

            $this->cms_model->updateSocialLink($data);
        }
        $data['social_link'] = $this->cms_model->getSocialLink();
        $content['page_content'] = $this->load->view(PAGE_SOCIAL, $data, TRUE);
        $this->load->view(PAGE_DASHBOARD, $content);
    }

    function activeStatus($id) {

        $data = array('article_status' => CONST_ACTIVE);
        $this->cms_model->updateArticle($data, $id);
        redirect(FN_CMS);
    }

    function deactiveStatus($id) {
        $data = array('article_status' => CONST_DEACTIVE);
        $this->cms_model->updateArticle($data, $id);
        redirect(FN_CMS);
    }

    function career() {
        if ($this->input->post('submit')) {
            
        }
        $data = '';
        $content['page_content'] = $this->load->view(PAGE_CAREER, $data, TRUE);
        $this->load->view(PAGE_DASHBOARD, $content);
    }

    function getChildcategory($type) {
        switch ($type) {
            case CMS_PAGE_GALLERY:
                $this->load->model('model_gallery');
                $data = $this->model_gallery->listParentCategory();
                break;
            case CMS_PAGE_SITE_MAP:

                break;
            case CMS_PAGE_FAQ:

                break;
            case CMS_PAGE_NEWS:
                $data = array(array(CONST_NEWS, 'News'), array(CONST_ACHIEVEMENT, 'Achievement'), array(CONST_EVENTS, 'Events'), array(CONST_PRESS_RELEASE, 'Press Release'));
                break;
            case CMS_PAGE_FEEDBACK:

                break;
            case CMS_PAGE_CAREER:

                break;
            case CMS_PAGE_MUL_LOCATION:
                $this->load->model('model_zone');
                $data = $this->model_zone->listParentCategory();
                break;
            case CMS_PAGE_PRODUCT:
                $this->load->model('model_product');
                $data = $this->model_product->listProducts(array('select' => array('name', 'id'), 'active' => CONST_ACTIVE));
                break;
        }
        if (!empty($data)) {
            echo json_encode(array('success' => true, 'message' => 'Success', 'data' => $data));
        } else {
            echo json_encode(array('success' => false, 'message' => 'No data found against this record!', 'data' => array()));
        }
    }

}
