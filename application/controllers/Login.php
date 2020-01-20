<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('login_view');
    }

    function aksi_login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $where = array(
            'FCCODE' => $username,
            'FCPASSWORD' => md5($password)
        );
        $cek = $this->Login_model->cek_login("USERS_TAB", $where)->row();

        if (empty($cek)) {
            echo "Username dan password salah !";
        } else {
            if ($username == $cek->FCCODE && md5($password) == $cek->FCPASSWORD) {
                $this->set_session($cek);
                redirect(site_url('Welcome'));
            } else {
                echo "Username dan password salah !";
            }
        }
    }

    function set_session($cek) {
        $userdata = $this->Login_model->get_userdata($cek->FCCODE);

        $data_session = array(
            'username' => $cek->FCCODE,
            'status' => "login",
            'fullname' => $cek->FULLNAME,
            'fcba' => $userdata['FCCODE']
        );
        //var_dump($userdata['FCCODE']);
        //exit;
        $this->session->set_userdata($data_session);
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }

}

?>