<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//This is the Book Model for CodeIgniter CRUD using Ajax Application.
class Login_model extends CI_Model{	
	function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}
	
	function get_userdata($username){
		$query = $this->db->query("Select 
								FCCODE, FCCOMPANYCODE, FCNAME, FCCOMPANYNAME,FCMANAGER,FCKTU,FCCROP,FCTYPE 
								from 
								BusinessUnit 
								INNER JOIN user_fcba_tab on BusinessUnit.fccode = user_fcba_tab.fcba and user_fcba_tab.isdefault = 'TRUE'
								where 
								user_fcba_tab.fcusercode = '".$username."'");
        return $query->row_array();
	}
}
?>