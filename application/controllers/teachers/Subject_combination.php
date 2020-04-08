<?php
defined('BASEPATH') OR exit('Access denied');

class Subject_combination extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('TeacherSess'))
		{
            redirect(base_url().'index');
		}
	}
	public function index($page='teachers/subject_combination')
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
		$data['Page_name']='Students';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['combinations']=$this->Teacher_model->get_subject_combination_grouped($organizerid,$teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['Page_name']='Subject Combination';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/subjectcombination_footer',$data);
	}
	
	public function view_subject_class($id=null)
	{
		$pages='teachers/view_combination_class';
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
		$data['Page_name']='Students';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['combinations']=$this->Teacher_model->get_subject_combination_grouped($organizerid,$teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['Page_name']='View Subjects';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/subjectcombination_footer',$data);	
	}
	public function view_combinations($id=null)
	{
		$pages='teachers/view_combinations';
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
		$data['Page_name']='Students';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['combinations']=$this->Teacher_model->get_subject_combination($organizerid,$teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['Page_name']='View Subjects';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/subject_footer',$data);	
	}
	//get subject details through ajax request
	public function get_subject_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$subject=$this->Organizer_model->get_subject_id($id,$organizerid);
		$result=$subject->result();
		echo json_encode($result);
	}
	//get subject details through ajax request
	public function get_subject_school($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$subject=$this->Organizer_model->get_subject_school($id,$organizerid);
		$result=$subject->result();
		echo json_encode($result);
	}
	
}