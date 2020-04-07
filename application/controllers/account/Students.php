<?php
defined('BASEPATH') OR exit('Access denied');

class Students extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/students')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['students']=$this->Organizer_model->get_students_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Students';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/students_footer',$data);
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

        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
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

        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$student_id=html_escape($this->input->post('id'));
        	$class=html_escape($this->input->post('class'));
        	$school=html_escape($this->input->post('school'));
        	$name=html_escape($this->input->post('name'));
        	$usernames=html_escape($this->input->post('username'));
     		//check if user already exists in the class
        	$student_exists_school=$this->db->select('*')->from('Student')->where('Reg_no',$usernames)->where('OrganizerId',$organizerid)->where('School_id',$school)->where('State',2)->where('Student_id !=',$student_id)->get();
        	if ($student_exists_school->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Student already exists in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Name' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Class'=>$class,'Status'=>1,'Reg_no'=>$usernames);
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
		$pages='account/view_student_class';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested Subjects School");
	        redirect($page);
		}
		$students=$this->db->select('*')->from('Student')->where('School_id',$schools->row()->School_id)->group_by('Class')->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['students']=$students;
		$data['Page_name']='View Students';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/subjectcombination_footer',$data);	
	}
	public function view_students($id=null)
	{
		$pages='account/view_students';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$classes=$this->db->select('*')->from('Classes')->where('ClassRef',$id)->where('OrganizerId',$organizerid)->get();
		if ($classes->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested Class Students");
	        redirect($page);
		}
		$students=$this->db->select('*')->from('Student')->where('Class',$classes->row()->Class_id)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['students']=$students;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Subjects';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/students_footer',$data);	
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
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$student_exists=$this->db->select('*')->from('Student')->where('OrganizerId',$organizerid)->where('Student_id',$id)->get();
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
	public function delete_student_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Student');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Students Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}