<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$userda = array('AdminSess',
						'Admin_id'
						 );
		$orgid=$this->session->userdata('Admin_id');
		$this->db->set('AdminSess','')->where('admin_id',$orgid)->update('sysadmin');
		$this->session->unset_userdata($userda);//destroying sessions
		$this->session->set_flashdata('message_success', "You have successfully signed out");
		redirect('sysadmin/login');
	}

}