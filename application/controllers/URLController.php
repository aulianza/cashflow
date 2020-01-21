<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class URLController extends CI_Controller {

    protected $datasend;

    public function __construct() {
        parent::__construct();
        $this->datasend = [];
//        if ($this->session->userdata('status') <> 'login') {
//            redirect(site_url("login"));
//            die();
//        }
        $this->datasend['SESSION'] = $this->session;
    }

    public function index() {
        $this->datasend['formid'] = 'home';
        $this->datasend['sidebar'] = 'sidebar_view';
        $this->datasend['content'] = 'home/welcome';
        $this->load->view('template', $this->datasend);
    }

    public function MasterUser() {
        $this->datasend['formid'] = 'home';
        $this->datasend['sidebar'] = '';
        $this->datasend['content'] = '';
        $this->load->view('template', $this->datasend);
    }

    public function MasterRole() {
        $this->datasend['formid'] = 'home';
        $this->datasend['sidebar'] = '';
        $this->datasend['content'] = '';
        $this->load->view('template', $this->datasend);
    }

}
