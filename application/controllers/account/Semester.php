<?php
defined('BASEPATH') OR exit('Access denied');

class Semester extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/semester')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['semesters']=$this->Organizer_model->get_semester_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Academic Semester/Term';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/semester_footer',$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Semester', 'trim|required');
		$this->form_validation->set_rules('school', 'School', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	for ($i=0; $i < count($name); $i++) 
        	{ 
        		$session_exists=$this->db->select('*')->from('Semester')->where('Name',$name[$i])->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        		if ($session_exists->num_rows()>0) 
        		{
        			$this->session->set_flashdata('message_error', "Semester Already exists in this school");
	            	redirect($page);
        		}
        		else
        		{
        			
        			$data_insert = array('Name' => $name[$i],'School_id'=>$school,'OrganizerId'=>$organizerid,'Status'=>1);
        			$add=$this->Organizer_model->create_semester($data_insert);
        		}
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Semester was successfully added");
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
	public function view_semester($id=null)
	{
		$pages='account/view_semester';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school Term");
	        redirect($page);
		}

		$semester=$this->db->select('*')->from('Semester')->where('School_id',$schools->row()->School_id)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['semesters']=$semester;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Academic Semester';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/semester_footer',$data);	
	}
	public function Edit_semester()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Semester', 'trim|required');
        $this->form_validation->set_rules('school','School','trim|required|numeric');
        $this->form_validation->set_rules('status','Status','trim|required|numeric');
        $this->form_validation->set_rules('id','Session Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$status=html_escape($this->input->post('status'));
        	$semester_id=html_escape($this->input->post('id'));
        	//check if Session already exists
        	$semester_exists=$this->db->select('*')->from('Semester')->where('Name',$name)->where('Semester_id!=',$semester_id)->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
        	if ($semester_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "Academic Semester Already Exists.");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$semester_data = array('Name' =>$name,'Status'=>$status,'School_id'=>$school);
	        	$update=$this->Organizer_model->update_semester($semester_data,$semester_id,$organizerid);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Academic Semester Successfully Updated.");
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
	//get semester details through ajax request
	public function get_semester_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$semester=$this->Organizer_model->get_semester_id($id,$organizerid);
		$result=$semester->result();
		echo json_encode($result);
	}
	//delete emester
	public function delete_semester()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Semester Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$semester_exists=$this->db->select('*')->from('Semester')->where('OrganizerId',$organizerid)->where('Semester_id',$id)->get();
        	if ($semester_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Academic Semester does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Semester_id',$id)->where('OrganizerId',$organizerid)->delete('Semester');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Academic Semester was Successfully Deleted");
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
	public function delete_semester_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerIds',$organizerid)->delete('Semester');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Academic Semester Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}