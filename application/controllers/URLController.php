<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class URLController extends CI_Controller {

    protected $datasend;

    public function __construct() {
        parent::__construct();
        $this->datasend = [];
        if ($this->session->userdata('USERNAME') == NULL) {
            redirect(site_url("login"));
            die();
        }
        $this->datasend['SESSION'] = $this->session;
    }

    public function MasterUser() {
        $this->datasend['formid'] = 'home';
        $this->datasend['content'] = '';
    }

    public function MasterRole() {
        $this->datasend['formid'] = 'home';
        $this->datasend['content'] = '';
    }

}
