<?php
/**
 * 
 */
class Payments extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/payments')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('OrganSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Payments';
		$data['payments']=$this->Organizer_model->get_payments($organizerid);
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/footer',$data);
	}
}