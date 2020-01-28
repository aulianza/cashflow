<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class URLController extends CI_Controller {

    protected $datasend;

    public function __construct() {
        parent::__construct();
        $this->datasend = [];
        if ($this->session->userdata('status') <> 'login') {
            redirect(site_url("login"));
            die();
        }
        $this->load->model('PermissionModel');
        $this->datasend['SESSION'] = $this->session;
        $this->datasend['Menu'] = $this->PermissionModel->GetMenu(1);
    }

    public function index() {
        $this->datasend['formid'] = 'home';
        $this->datasend['sidebar'] = 'sidebar_view';
        $this->datasend['content'] = 'home/welcome';
        $this->load->view('template', $this->datasend);
    }

    public function MstUser() {
        $this->datasend['formid'] = 'home';
        $this->datasend['sidebar'] = 'sidebar_view';
        $this->datasend['content'] = 'MasterData/MstUser';
        $this->load->view('template', $this->datasend);
    }

    public function MstRoleAccess() {
        $this->datasend['formid'] = 'home';
        $this->datasend['sidebar'] = 'sidebar_view';
        $this->datasend['content'] = 'MasterData/MstRoleAccess';
        $this->load->view('template', $this->datasend);
    }

}
