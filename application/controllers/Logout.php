<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$userda = array('OrganSess',
						'Organid'
						 );
		$orgid=$this->session->userdata('Organid');
		$this->db->set('OrganSess','')->where('OrganizerId',$orgid)->update('organizer');
		$this->session->unset_userdata($userda);//destroying sessions
		$this->session->set_flashdata('message_success', "You have successfully signed out");
		redirect('login');
	}

}