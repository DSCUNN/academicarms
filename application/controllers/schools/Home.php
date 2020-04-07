<?php

/* 	This class controls the home view for schools as 
 * 	routed in the Route file in the config folder.
 *	Do not change this file without changing the 
 *	route process first to avoid errors.
 */
class Home extends CI_Controller
{
	public function index($page='schools/home')
	{
		//retrieve the requested url and sanitizing against invisible characters 
		$school= remove_invisible_characters(strtolower($this->uri->segment(2)));
		//check if school exists.
		$school_exists=$this->db->select('*')->from('Schools')->where('School_url',$school)->get();
		if ($school_exists->num_rows()>0) 
		{
			$school_status=$school_exists->row()->School_status;
			if ($school_status!=1) 
			{
				$this->session->set_flashdata('message_error','We cannot display the requested school at the moment. Contact your school System administrator for more information');
				redirect('index');
			}
			else
			{
				$school_sess = array('school' => $school_exists->row());
				$this->session->set_userdata($school_sess);
				$general_settings=$this->Web_model->general_settings();
				$data['general_settings']=$general_settings;
				$data['school']=$school_exists->row();
				$data['pagename']='Home Page';
				$data['Site_name']=$school_exists->row()->School_name;
				$data['url_slug']=$school_exists->row()->School_url;
				$this->load->view($page,$data);
			}
		}
		else
		{
			$this->session->set_flashdata('message_error','The requested school does not exist. This could be as a result of misspelling or network glitch.');
			redirect('index');
		}
	}
}