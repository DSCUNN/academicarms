<?php
defined('BASEPATH') OR exit('Access denied');

class Teachers extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/teachers')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['teachers']=$this->Organizer_model->get_teachers_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Teachers';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/teacher_footer',$data);
	}
	public function Create_teacher()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Teacher Name', 'trim|required');
		$this->form_validation->set_rules('email[]', 'Teacher Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password[]', 'Teacher Password', 'trim');
		$this->form_validation->set_rules('school', 'School Name', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
        	$classess=array();
        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$password=html_escape($this->input->post('password'));
        	$email=html_escape($this->input->post('email'));
        	for ($i=0; $i < count($name); $i++) 
        	{ 
        		$teacher_exists=$this->db->select('*')->from('Teacher')->where('Email',$email[$i])->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        		if ($teacher_exists->num_rows()>0) 
        		{
        			$this->session->set_flashdata('message_error', "Teacher Already exists in this school");
	            	redirect($page);
        		}
        		else
        		{
        			if (empty($password[$i])) 
        			{
        				$passwords=password_hash($general_settings->row()->Default_password, PASSWORD_BCRYPT);
        			}
        			else
        			{
        				$passwords=password_hash($password[$i], PASSWORD_BCRYPT);
        			}
        			$data_insert = array('Name' => $name[$i],'School_id'=>$school,'OrganizerId'=>$organizerid,'Email'=>$email[$i],'Password'=>$passwords,'Status'=>1);
        			$add=$this->Organizer_model->create_teachers($data_insert);
        		}
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Teacher was successfully added");
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
	public function view_teachers($id=null)
	{
		$pages='account/view_teachers';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		$teachers=$this->db->select('*')->from('Teacher')->where('School_id',$schools->row()->School_id)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school class");
	        redirect($page);
		}
		if ($teachers->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested classes");
	        redirect($page);
		}
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['teachers']=$teachers;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Teachers';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/teacher_footer',$data);	
	}
	public function Edit_teacher()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Teacher Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Teacher Email', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('id','Teacher Id','trim|required|numeric');
        $this->form_validation->set_rules('school','School','trim|required|numeric');
        $this->form_validation->set_rules('class','Class','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$class=html_escape($this->input->post('class'));
        	$school=html_escape($this->input->post('school'));
        	$status=html_escape($this->input->post('status'));
        	$teacher_id=html_escape($this->input->post('id'));
        	//check if teacher already exists
        	$teacher_exists=$this->db->select('*')->from('Teacher')->where('Email',$email)->where('Teacher_id!=',$teacher_id)->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
        	//checking if class had already been assigned to another teacher
        	$class_asigned=$this->db->select('*')->from('Teacher')->where('Class',$class)->where('Teacher_id!=',$teacher_id)->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
        	if ($teacher_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "Teacher Already Exists.");
	        	redirect($page);	
        	}
        	elseif ($class_asigned->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "Class has been assigned to another teacher.");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$teacher_data = array('Name' =>$name,'Status'=>$status,'School_id'=>$school,'Class'=>$class,'Email'=>$email);
	        	$update=$this->Organizer_model->update_teacher($teacher_data,$teacher_id,$organizerid);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Teacher Successfully Updated.");
	        		redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Something Went Wrong. Please Try Again.");
	        		redirect($page);
	        	}
	        }
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
        	redirect($page);
        }
	}
	//get teacher details through ajax request
	public function get_teacher_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$teacher=$this->Organizer_model->get_teacher_id($id,$organizerid);
		$result=$teacher->result();
		echo json_encode($result);
	}
	//get classes details through ajax request
	public function get_class_school($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$classes=$this->Organizer_model->get_classes_school($organizerid,$id);
		$result=$classes->result();
		echo json_encode($result);
	}
	//delete teacher
	public function delete_teacher()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Teacher Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$teacher_exists=$this->db->select('*')->from('Teacher')->where('OrganizerId',$organizerid)->where('Teacher_id',$id)->get();
        	if ($teacher_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Teacher does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Teacher_id',$id)->where('OrganizerId',$organizerid)->delete('Teacher');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Teacher was Successfully Deleted");
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
	public function delete_teacher_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Teacher');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Teachers Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}