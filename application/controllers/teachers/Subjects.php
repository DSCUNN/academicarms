<?php
defined('BASEPATH') OR exit('Access denied');

class Subjects extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('TeacherSess'))
		{
            redirect(base_url().'index');
		}
	}
	public function index($page='teachers/subjects')
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
		$data['students']=$this->Teacher_model->get_students_class_grouped($teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['subjects']=$this->Organizer_model->get_subjects_grouped($organizerid);
		$data['Page_name']='Subjects';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/subject_footer',$data);
	}
	public function view_subjects($id=null)
	{
		$pages='teachers/view_subjects';
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
		$data['students']=$this->Teacher_model->get_students_class_grouped($teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);

		$subjects=$this->db->select('*')->from('Subject')->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['subjects']=$subjects;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Subjects';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/subject_footer',$data);	
	}
}