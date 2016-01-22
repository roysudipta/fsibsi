<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cms_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tbl_article = 'cms_articles';

    public function listArticles() {
        $query = $this->db->get($this->tbl_article);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }
    
    public function getArticle($id, $select = NULL) {
        if ($select != NULL) {
            $query = $this->db->select($select)->get_where($this->table_article, array('id' => $id));
        } else {
            $query = $this->db->get_where($this->table_article, array('id' => $id));
        }
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function saveArticle($data) {
        $this->db->insert($this->table_article, $data);
    }

    public function updateArticle($data, $id) {
        $this->db->update($this->table_article, $data, array('id' => $id));
    }

    public function getArticleBySlug($slug) {
        $query = $this->db->get_where($this->table_article, array('article_slug' => $slug));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }
}
