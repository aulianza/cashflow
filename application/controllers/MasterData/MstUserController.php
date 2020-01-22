<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MstUserController extends BaseController {

    public function __construct() {
        parent::__construct();
        $this->datasend = [];
        $this->load->model('UsersModel');
    }

    public function ShowData() {
        try {
            $list = $this->UsersModel->ShowData();
            $this->resource = array(
                'status' => 200,
                'data' => $list
            );
        } catch (Exception $ex) {
            $this->resource = array(
                'status' => 500,
                'data' => $ex->getMessage()
            );
        }
        $this->SendResponse();
    }

}
