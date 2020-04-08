<?php
defined('BASEPATH') OR exit('Access denied');

class Classes extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/classes')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['classes']=$this->Organizer_model->get_classes_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Classes';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/class_footer',$data);
	}
	public function Create_class()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Class Name', 'trim|required');
		$this->form_validation->set_rules('school', 'School Name', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
        	$classess=array();
        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$status=html_escape($this->input->post('status'));
        	for ($i=0; $i < count($name); $i++) 
        	{ 
        		$class_exists=$this->db->select('*')->from('Classes')->where('Name',$name[$i])->where('OrganizerId',$organizerid)->where('School',$school)->get();
        		if ($class_exists->num_rows()>0) 
        		{
        			$this->session->set_flashdata('message_error', "Class Already exists in this school");
	            	redirect($page);
        		}
        		else
        		{
        			$classref=$general_settings->row()->Site_shortname."-".rand(100000,9999999);
        			$data_insert = array('Name' => $name[$i],'School'=>$school,'OrganizerId'=>$organizerid,'Status'=>$status,'ClassRef'=>$classref);
        			$add=$this->Organizer_model->create_class($data_insert);
        		}
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Class was successfully added");
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
	public function view_classes($id=null)
	{
		$pages='account/view_classes';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		$classes=$this->db->select('*')->from('Classes')->where('School',$schools->row()->School_id)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school class");
	        redirect($page);
		}
		if ($classes->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested classes");
	        redirect($page);
		}
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['classes']=$classes;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Classes';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/class_footer',$data);	
	}
	public function Edit_class()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Class Name', 'trim|required');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('id','Class Id','trim|required|numeric');
        $this->form_validation->set_rules('school','School','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$status=html_escape($this->input->post('status'));
        	$class_id=html_escape($this->input->post('id'));
        	//check if class already exists
        	$class_exists=$this->db->select('*')->from('Classes')->where('Name',$name)->where('Class_id!=',$class_id)->where('School',$school)->where('OrganizerId',$organizerid)->get();
        	if ($class_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "Class Already Exists.");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$class_data = array('Name' =>$name,'Status'=>$status,'School'=>$school);
	        	$update=$this->Organizer_model->update_class($class_data,$class_id,$organizerid);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Class Successfully Updated.");
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
	//get class details through ajax request
	public function get_class_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$class=$this->Organizer_model->get_class_id($id,$organizerid);
		$result=$class->result();
		echo json_encode($result);
	}
	//delete class
	public function delete_class()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Class Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$class_exists=$this->db->select('*')->from('Classes')->where('OrganizerId',$organizerid)->where('Class_id',$id)->get();
        	if ($class_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Class does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Class_id',$id)->where('OrganizerId',$organizerid)->delete('Classes');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Class was Successfully Deleted");
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
	public function delete_class_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Classes');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Classes Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}