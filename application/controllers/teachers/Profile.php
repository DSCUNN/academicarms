<?php 

class Profile extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('TeacherSess'))
		{
            redirect(base_url().'index');
		}
	}
	public function index($page='teachers/profile')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('TeacherSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		//retrieving data from stored sessions
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		if ($school_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','You have no access to this page');
			redirect($redirect_page);
		}
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['Page_name']='Teacher Profile';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$this->load->view('teachers/templates/header.php',$data);
		$this->load->view('teachers/templates/sidemenu.php',$data);
		$this->load->view('teachers/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/footer.php',$data);
	}
}