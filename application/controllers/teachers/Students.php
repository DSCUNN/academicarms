<?php
defined('BASEPATH') OR exit('Access denied');

class Students extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('TeacherSess'))
		{
            redirect(base_url().'index');
		}
	}
	public function index($page='teachers/students')
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
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/students_footer',$data);
	}
	public function Create_students()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('school', 'School', 'trim|numeric|required');
		$this->form_validation->set_rules('name[]', 'Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username[]', 'Reg. Number', 'trim');
		if ($this->form_validation->run() == TRUE)
        {

        	//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$teacher_sess=$this->session->userdata('TeacherSess');
			$teacher_id=$this->session->userdata('Teacherid');
			$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);

        	$classess=array();
        	$class=html_escape($this->input->post('class'));
        	$school=html_escape($this->input->post('school'));
        	$name=html_escape($this->input->post('name'));
        	$username=html_escape($this->input->post('username'));
        	for ($i=0; $i < count($name); $i++) 
        	{ 
        		if (empty($username[$i])) 
	        	{
	        		$usernames=$general_settings->row()->Site_shortname."/".date('Y')."/".rand(100000,999999);
	        	}
	        	else
	        	{
	        		$usernames=$username;
	        	}
        		$student_exists_school=$this->db->select('*')->from('Student')->where('Reg_no',$username[$i])->where('OrganizerId',$organizerid)->where('School_id',$school)->where('State',2)->get();
        		if ($student_exists_school->num_rows()>0) 
        		{
        			$this->session->set_flashdata('message_error', "Student already exists in this school");
	            	redirect($page);
        		}
        		else
        		{
        			
        			$data_insert = array('Name' => $name[$i],'School_id'=>$school,'OrganizerId'=>$organizerid,'Class'=>$class,'Status'=>1,'Reg_no'=>$usernames);
        			$add=$this->Organizer_model->create_student($data_insert);
        		}
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Students successfully added.");
	            redirect($page);
        	}
        	else
        	{
        		$this->session->set_flashdata('message_error', "Process Failed");
	            redirect($page);
        	}
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	public function Edit_student()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('id', 'Student', 'trim|required|numeric');
		$this->form_validation->set_rules('school', 'School', 'trim|numeric|required');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username', 'Reg. Number', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {

        	//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$teacher_sess=$this->session->userdata('TeacherSess');
			$teacher_id=$this->session->userdata('Teacherid');
			$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);

        	$student_id=html_escape($this->input->post('id'));
        	$class=html_escape($this->input->post('class'));
        	$school=html_escape($this->input->post('school'));
        	$name=html_escape($this->input->post('name'));
        	$username=html_escape($this->input->post('username'));
     		//check if user already exists in the class
        	$student_exists_school=$this->db->select('*')->from('Student')->where('Reg_no',$username)->where('OrganizerId',$organizerid)->where('School_id',$school)->where('State',2)->where('Student_id !=',$student_id)->get();
        	if ($student_exists_school->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Student already exists in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Name' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Class'=>$class,'Status'=>1,'Reg_no'=>$username);
        		$add=$this->Organizer_model->update_student($data_insert,$student_id,$organizerid);
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Students successfully Update.");
	            redirect($page);
        	}
        	else
        	{
        		$this->session->set_flashdata('message_error', "Process Failed");
	            redirect($page);
        	}
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	public function view_student_class($id=null)
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		$pages='teachers/view_student_class';
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
		$data['students']=$this->Teacher_model->get_students_class_grouped($teacher->row()->Class);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['Page_name']='Students';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['general_settings']=$general_settings;
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['Page_name']='View Students';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/subjectcombination_footer',$data);	
	}
	public function view_students($id=null)
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		$pages='teachers/view_students';
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
		$data['students']=$this->Teacher_model->get_students_class($teacher->row()->Class);
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['Page_name']='Students';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$data['general_settings']=$general_settings;
		$data['schools']=$this->Organizer_model->get_school_id($school,$organizerid);
		$data['Page_name']='View Students';
		$this->load->view('teachers/templates/header',$data);
		$this->load->view('teachers/templates/sidemenu',$data);
		$this->load->view('teachers/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('teachers/templates/students_footer',$data);	
	}
	//get student details through ajax request
	public function get_student_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$student=$this->Organizer_model->get_student_id($id,$organizerid);
		$result=$student->result();
		echo json_encode($result);
	}
	//delete student
	public function delete_student()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Student Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	//retrieving data from stored sessions
			$school=$this->session->userdata('School_teacher');
			$organizerid=$this->session->userdata('School_organ');
			$teacher_sess=$this->session->userdata('TeacherSess');
			$teacher_id=$this->session->userdata('Teacherid');
			$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
			$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$student_exists=$this->db->select('*')->from('Student')->where('OrganizerId',$organizerid)->where('Student_id',$id)->where('Class',$teacher->row()->Class)->get();
        	if ($student_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Student does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Student_id',$id)->where('OrganizerId',$organizerid)->delete('Student');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Student was Successfully Deleted");
		        	redirect($page);
        		}
        		else
        		{
        			$this->session->set_flashdata('message_error', "Process Failed");
		        	redirect($page);
        		}
        	}
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
	                                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
	                                    <span>$errors</span>
	                                </div>");
            redirect($page);
        }
	}
	//get classes details through ajax request
	public function get_class_school($id)
	{
		//retrieving data from stored sessions
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		$classes=$this->Teacher_model->get_classes_school($organizerid,$id,$teacher->row()->Class);
		$result=$classes->result();
		echo json_encode($result);
	}
	//get classes details through ajax request
	public function get_class_schools($id)
	{
		//retrieving data from stored sessions
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$classes=$this->Organizer_model->get_classes_school($organizerid,$id);
		$result=$classes->result();
		echo json_encode($result);
	}
}