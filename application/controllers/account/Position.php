<?php
defined('BASEPATH') OR exit('Access denied');

class Position extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/position')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['positions']=$this->Organizer_model->position_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Positions';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/position_footer',$data);
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
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

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
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

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
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$type=$this->db->select('*')->from('Result_type')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	//get details through ajax request
	public function get_school_term($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$type=$this->db->select('*')->from('Semester')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	//get details through ajax request
	public function get_school_session($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$type=$this->db->select('*')->from('Session')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	public function get_class_student($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$type=$this->db->select('*')->from('Student')->where('OrganizerId',$organizerid)->where('Class',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	public function get_position_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$type=$this->db->select('*')->from('Position')->where('OrganizerId',$organizerid)->where('Position_id',$id)->get();
		$result=$type->result();
		echo json_encode($result);
	}
	public function school($id=null)
	{
		$pages='account/position_school';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$id;
		$data['school']=$schools;
		$data['classes']=$this->Organizer_model->get_classes_school($organizerid,$schools->row()->School_id);
		$data['positions']=$this->Organizer_model->position_school($schools->row()->School_id,$organizerid);
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/position_footer',$data);	
	}
	public function session($id=null)
	{
		$pages='account/position_session';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$positions=$this->Organizer_model->position_session($schools->row()->School_id,$organizerid,$session_mk);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['positions']=$positions;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/position_footer',$data);	
	}
	public function semester($id=null)
	{
		$pages='account/position_semester';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$positions=$this->Organizer_model->position_semester($session_mk,$semester_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['positions']=$positions;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/position_footer',$data);	
	}
	public function classes($id=null)
	{
		$pages='account/position_class';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$class_mk=$this->uri->segment(7);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$positions=$this->Organizer_model->position_class($session_mk,$semester_mk,$class_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['positions']=$positions;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/position_footer',$data);	
	}
	public function student($id=null)
	{
		$pages='account/position_student';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$class_mk=$this->uri->segment(7);
		$student_mk=$this->uri->segment(8);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$positions=$this->Organizer_model->position_student($session_mk,$semester_mk,$class_mk,$student_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['positions']=$positions;
		$data['school_mk']=$school_mk;
		$data['session_mk']=$session_mk;
		$data['semester_mk']=$semester_mk;
		$data['class_mk']=$class_mk;
		$data['student_mk']=$student_mk;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/position_footer',$data);	
	}
	public function type($id=null)
	{
		$pages='account/position_type';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$class_mk=$this->uri->segment(7);
		$student_mk=$this->uri->segment(8);
		$type_mk=$this->uri->segment(9);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$positions=$this->Organizer_model->position_type($session_mk,$semester_mk,$class_mk,$student_mk,$type_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['positions']=$positions;
		$data['school_mk']=$school_mk;
		$data['session_mk']=$session_mk;
		$data['semester_mk']=$semester_mk;
		$data['class_mk']=$class_mk;
		$data['student_mk']=$student_mk;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/position_footer',$data);	
	}
}