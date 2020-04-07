<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {

	public function index()
	{
		$userda = array('TeacherSess',
						'Teacherid'
						 );
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$school_url=$school_exists->row()->School_url;
		$orgid=$this->session->userdata('Teacherid');
		$url=base_url().'schools/'.$school_url.'/teachers';
		$this->db->set('TeacherSess','')->where('Teacher_id',$orgid)->update('teacher');
		$this->session->unset_userdata($userda);//destroying sessions
		$this->session->set_flashdata('message_success', "You have successfully signed out");
		redirect($url);
	}

}