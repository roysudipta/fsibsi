<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public $tblInvoiceRate = 'invoice_rates';
    public $tblInvoices = 'invoice';
    public $tblEvent = 'events';
    public $tblTeam = 'participant_team';

    public function listInvoices($param = array()) {

        $query = $this->db->select($this->tblInvoices . '.*', $this->tblEvent . '.id', $this->tblEvent . '.event_name', $this->tblTeam . '.team_name')
                ->join($this->tblTeam, $this->tblTeam . '.id = ' . $this->tblInvoices . '.team_id')
                ->join($this->tblEvent, $this->tblEvent . '.id = ' . $this->tblTeam . '.event_id')
                ->get($this->tblInvoices);

        return $query->result_array();
    }

    public function listInvoiceSettings($param = array()) {
        if (array_key_exists('select', $param)) {
            $this->db->select($param['select']);
        }
        if (array_key_exists('where', $param)) {
            $this->db->where($param['where']);
        }
        if (array_key_exists('join', $param)) {
            $this->db->join($param['join'], $param['join_on']);
        }
        if (array_key_exists('order_by', $param)) {
            $this->db->order_by($param['order_by']);
        }

        $query = $this->db->get($this->tblInvoiceRate);

        return $query->result_array();
    }

    public function getInvoice($id) {
        $query = $this->db->select(array($this->tblInvoices . '.*'))
                ->get_where($this->tblInvoices, array($this->tblInvoices . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function getInvoiceRateByEventID($event_id) {
        $query = $this->db->select(array($this->tblInvoiceRate . '.*'))
                ->get_where($this->tblInvoiceRate, array($this->tblInvoiceRate . '.event_id' => $event_id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function getInvoiceRateByID($id) {
        $query = $this->db->select(array($this->tblInvoiceRate . '.*'))
                ->get_where($this->tblInvoiceRate, array($this->tblInvoiceRate . '.id' => $id));
        if ($query->num_rows() >= 1) {
            return $query->row_array();
        }
    }

    public function update($table, $data, $id) {
        $query = $this->db->update($table, $data, array('id' => $id));
        if ($query == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function add($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

}
