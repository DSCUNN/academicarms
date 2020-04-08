<?php 

class Dashboard extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "< You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/dashboard')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['Page_name']='Dashboard';
		$data['total_students']=$this->db->select('*')->from('student')->where('OrganizerId',$organizerid)->get();
		$data['total_class']=$this->db->select('*')->from('classes')->where('OrganizerId',$organizerid)->get();
		$data['total_teachers']=$this->db->select('*')->from('teacher')->where('OrganizerId',$organizerid)->get();
		$data['total_results_published']=$this->db->select('*')->from('result')->where('OrganizerId',$organizerid)->where('Status',1)->get();
		$data['total_results_unpublished']=$this->db->select('*')->from('result')->where('OrganizerId',$organizerid)->where('Status!=',1)->get();
		$data['total_result_pins']=$this->db->select('*')->from('result_pins')->where('OrganizerId',$organizerid)->get();
		$data['total_unused_pins']=$this->db->select('*')->from('result_pins')->where('OrganizerId',$organizerid)->where('Status',1)->get();
		$data['total_used_pins']=$this->db->select('*')->from('result_pins')->where('OrganizerId',$organizerid)->where('Status!=',1)->get();
		$data['total_subjects']=$this->db->select('*')->from('subject')->where('OrganizerId',$organizerid)->get();
		$data['total_schools']=$this->db->select('*')->from('schools')->where('OrganizerId',$organizerid)->get();
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/footer.php',$data);
	}
}