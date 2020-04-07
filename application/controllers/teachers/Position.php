<?php
defined('BASEPATH') OR exit('Access denied');

class Position extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('TeacherSess'))
		{
            redirect(base_url().'index');
		}
	}
	public function index($page='teachers/position')
	{
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
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['combinations']=$this->Teacher_model->get_subject_combination($organizerid,$teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position($teacher->row()->Class,$school);
		$data['Page_name']='Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/position_footer',$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules		
		$this->form_validation->set_rules('school', 'School', 'trim|required|numeric');
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');	
		$this->form_validation->set_rules('aca_session', 'Academic Session', 'trim|required|numeric');	
		$this->form_validation->set_rules('term', 'Semester', 'trim|required|numeric');
		$this->form_validation->set_rules('student', 'Student', 'trim|required|numeric');
		$this->form_validation->set_rules('result_type', 'Result Type', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Position', 'trim|required');	
		$this->form_validation->set_rules('teacher', 'Teacher Comment', 'trim');	
		$this->form_validation->set_rules('principal', 'principal Comment', 'trim');
		$this->form_validation->set_rules('headteacher', 'Head teacher Comment', 'trim');						
		if ($this->form_validation->run() == TRUE)
        {
        	//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);

        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$class=html_escape($this->input->post('class'));
        	$aca_session=html_escape($this->input->post('aca_session'));
        	$term=html_escape($this->input->post('term'));
        	$student=html_escape($this->input->post('student'));
        	$result_type=html_escape($this->input->post('result_type'));
        	$teacher=html_escape($this->input->post('teacher'));
        	$headteacher=html_escape($this->input->post('headteacher'));
        	$principal=html_escape($this->input->post('principal'));
        	$position_exists=$this->db->select('*')->from('Position')->where('Student',$student)->where('Class',$class)->where('Result_type',$result_type)->where('Session',$aca_session)->where('Term',$term)->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        	if ($position_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Position Already Declared for student in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Position' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Student'=>$student,'Class'=>$class,'Result_type'=>$result_type,'Session'=>$aca_session,'Term'=>$term,'Teacher_comment'=>$teacher,'Headteacher_comment'=>$headteacher,'Principal_comment'=>$principal);
        		$add=$this->Organizer_model->create_position($data_insert);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Position was successfully added");
		            redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Process Failed");
		            redirect($page);
	        }	}
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	public function edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules		
		$this->form_validation->set_rules('id', 'Position Id', 'trim|required|numeric');
		$this->form_validation->set_rules('name', 'Position', 'trim|required');	
		$this->form_validation->set_rules('teacher', 'Teacher Comment', 'trim');	
		$this->form_validation->set_rules('principal', 'principal Comment', 'trim');
		$this->form_validation->set_rules('headteacher', 'Head teacher Comment', 'trim');						
		if ($this->form_validation->run() == TRUE)
        {
        	//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);

        	$name=html_escape($this->input->post('name'));
        	$positionid=html_escape($this->input->post('id'));
        	$teacher=html_escape($this->input->post('teacher'));
        	$headteacher=html_escape($this->input->post('headteacher'));
        	$principal=html_escape($this->input->post('principal'));

        	$position_exists=$this->db->select('*')->from('Position')->where('OrganizerId',$organizerid)->where('Position_id',$positionid)->get();
        	if ($position_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message_error', "You have no clearance to edit this position.");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Position' => $name,'Teacher_comment'=>$teacher,'Headteacher_comment'=>$headteacher,'Principal_comment'=>$principal);
        		$add=$this->Organizer_model->update_position($data_insert,$positionid);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Position was successfully updated");
		            redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Process Failed");
		            redirect($page);
	        }	}
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	//get details through ajax request
	public function get_school_result_type($id)
	{
		//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$type=$this->db->select('*')->from('Result_type')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	//get details through ajax request
	public function get_school_term($id)
	{
		//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$type=$this->db->select('*')->from('Semester')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	//get details through ajax request
	public function get_school_session($id)
	{
		//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$type=$this->db->select('*')->from('Session')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	public function get_class_student($id)
	{
		//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$type=$this->db->select('*')->from('Student')->where('OrganizerId',$organizerid)->where('Class',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	public function get_position_id($id)
	{
		//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$type=$this->db->select('*')->from('Position')->where('OrganizerId',$organizerid)->where('Position_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	public function school($id=null)
	{
		$pages='teachers/position_school';
		$page=$_SERVER['HTTP_REFERER'];
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
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['combinations']=$this->Teacher_model->get_subject_combination($organizerid,$teacher->row()->Class);
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position($teacher->row()->Class,$school);
		$data['Page_name']='Positions';
		$data['classes']=$this->Teacher_model->get_classes_school($organizerid,$school,$teacher->row()->Class);
		$data['positions']=$this->Teacher_model->get_position($teacher->row()->Class);
		$data['Page_name']=' Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/position_footer',$data);	
	}
	public function session($id=null)
	{
		$pages='teachers/position_session';
		$page=$_SERVER['HTTP_REFERER'];
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
		$session_mk=$this->uri->segment(5);
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position_session($session_mk,$teacher->row()->Class,$school);
		$data['Page_name']='Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/position_footer',$data);	
	}
	public function semester($id=null)
	{
		$pages='teachers/position_semester';
		$page=$_SERVER['HTTP_REFERER'];
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
		$session_mk=$this->uri->segment(5);
		$term_mk=$this->uri->segment(6);
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position_term($session_mk,$term_mk,$teacher->row()->Class,$school);
		$data['Page_name']='Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/position_footer',$data);	
	}
	public function classes($id=null)
	{
		$pages='teachers/position_class';
		$page=$_SERVER['HTTP_REFERER'];
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
		$session_mk=$this->uri->segment(5);
		$term_mk=$this->uri->segment(6);
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position_class($session_mk,$term_mk,$teacher->row()->Class,$school);
		$data['Page_name']='Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/position_footer',$data);	
	}
	public function student($id=null)
	{
		$pages='teachers/position_student';
		$page=$_SERVER['HTTP_REFERER'];
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
		$session_mk=$this->uri->segment(5);
		$term_mk=$this->uri->segment(6);
		$student=$this->uri->segment(8);
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position_student($session_mk,$term_mk,$teacher->row()->Class,$student,$school);
		$data['Page_name']='Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/position_footer',$data);	
	}
	public function type($id=null)
	{
		$pages='teachers/position_type';
		$page=$_SERVER['HTTP_REFERER'];
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
		$session_mk=$this->uri->segment(5);
		$term_mk=$this->uri->segment(6);
		$student=$this->uri->segment(8);
		$type_mk=$this->uri->segment(9);
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['positions']=$this->Teacher_model->get_position_student_type($session_mk,$term_mk,$teacher->row()->Class,$student,$type_mk,$school);
		$data['Page_name']='Positions';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/position_footer',$data);	
	}
}