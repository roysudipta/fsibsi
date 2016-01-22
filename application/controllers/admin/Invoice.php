<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends FB_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('event_model');
        $this->load->model('invoice_model');
    }

    public $tblInvoiceRate = 'invoice_rates';
    public $tblInvoice = 'invoice';
    public $tblEvent = 'events';

    public function listSettings() {

        $data['settings'] = $this->invoice_model->listInvoiceSettings(array('select' => array($this->tblInvoiceRate . '.*', $this->tblEvent . '.event_name'),
            'join' => $this->tblEvent,
            'join_on' => $this->tblInvoiceRate . '.event_id = ' . $this->tblEvent . '.id'));

        $data['events'] = $this->event_model->listEvents();

        $this->_AdminView(PAGE_ADMIN_INVOICE_SETTINGS, $data);
    }

    public function listInvoices() {
        $data['invoices'] = $this->invoice_model->listInvoices();
        
        $this->_AdminView(PAGE_ADMIN_INVOICE_INVOICES,$data);
    }

    public function getSettingDetails() {
        $this->load->view();
    }

    public function saveSettingDetails() {
        $this->load->view();
    }

    public function getInvoiceDetails() {
        $this->load->view();
    }

    public function saveInvoiceDetails() {
        $this->load->view();
    }

    public function printInvoice() {
        $this->load->view();
    }

}
