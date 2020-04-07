<?php
/**
 * 
 */
class Faq_requests extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/faq_requests')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('AdminSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		//retrieving data from stored sessions
		$admin_sess=$this->session->userdata('AdminSess');
		$admin_id=$this->session->userdata('Admin_id');
		$admin=$this->Admin_model->admin_details($admin_id,$admin_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Faq Requests';
		$data['admin']=$admin;
		$data['faq']=$this->Admin_model->get_faq_request();
		$data['category']=$this->Admin_model->get_faq_category();
		$this->load->view('sysadmin/templates/header',$data);
		$this->load->view('sysadmin/templates/sidemenu',$data);
		$this->load->view('sysadmin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer',$data);
	}
	public function delete($id=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_faq_request_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Question does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$delete=$this->db->where('Request_id',$id)->delete('faq_request');
			if ($delete==true) 
			{
				$this->session->set_flashdata('message_success','Successfully Removed');
				redirect($page);
			}
			else
			{
				$this->session->set_flashdata('message_error','Something went wrong and we could not process your request');
				redirect($page);
			}
		}
	}
}