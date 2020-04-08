<?php
defined('BASEPATH') OR exit('Access denied');

class Subjects extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/subjects')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['subjects']=$this->Organizer_model->get_subjects_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Subjects';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/subject_footer',$data);
	}
	public function Create_subject()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Subject Name', 'trim|required');
		$this->form_validation->set_rules('code[]', 'Subject Code', 'trim');
		$this->form_validation->set_rules('load[]', 'Unit Load', 'trim|numeric');
		$this->form_validation->set_rules('school', 'School Name', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
        	$classess=array();
        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$code=html_escape($this->input->post('code'));
        	$load=html_escape($this->input->post('load'));
        	for ($i=0; $i < count($name); $i++) 
        	{ 
        		$subject_exists=$this->db->select('*')->from('Subject')->where('Subject_name',$name[$i])->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        		if ($subject_exists->num_rows()>0) 
        		{
        			$this->session->set_flashdata('message_error', "Subject Already exists in this school");
	            	redirect($page);
        		}
        		else
        		{
        			
        			$data_insert = array('Subject_name' => $name[$i],'School_id'=>$school,'OrganizerId'=>$organizerid,'Unit_load'=>$load[$i],'Subject_code'=>$code[$i],'Status'=>1);
        			$add=$this->Organizer_model->create_subjects($data_insert);
        		}
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Subjects was successfully added");
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
	public function view_subjects($id=null)
	{
		$pages='account/view_subjects';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school Subjects");
	        redirect($page);
		}

		$subjects=$this->db->select('*')->from('Subject')->where('School_id',$schools->row()->School_id)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['subjects']=$subjects;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Subjects';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/subject_footer',$data);	
	}
	public function Edit_subject()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Subject Name', 'trim|required');
		$this->form_validation->set_rules('code', 'Subject Code', 'trim');
		$this->form_validation->set_rules('load', 'Unit Load', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('id','Teacher Id','trim|required|numeric');
        $this->form_validation->set_rules('school','School','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$code=html_escape($this->input->post('code'));
        	$load=html_escape($this->input->post('load'));
        	$school=html_escape($this->input->post('school'));
        	$status=html_escape($this->input->post('status'));
        	$subject_id=html_escape($this->input->post('id'));
        	//check if Subject already exists
        	$subject_exists=$this->db->select('*')->from('Subject')->where('Subject_name',$name)->where('Subject_id!=',$subject_id)->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
        	if ($subject_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "Subject Already Exists.");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$subject_data = array('Subject_name' =>$name,'Status'=>$status,'School_id'=>$school,'Subject_code'=>$code,'Unit_load'=>$load);
	        	$update=$this->Organizer_model->update_subject($subject_data,$subject_id,$organizerid);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Subject Successfully Updated.");
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
	//get subject details through ajax request
	public function get_subject_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$subject=$this->Organizer_model->get_subject_id($id,$organizerid);
		$result=$subject->result();
		echo json_encode($result);
	}
	//delete subject
	public function delete_subject()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Subject Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$subject_exists=$this->db->select('*')->from('Subject')->where('OrganizerId',$organizerid)->where('Subject_id',$id)->get();
        	if ($subject_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Subject does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Subject_id',$id)->where('OrganizerId',$organizerid)->delete('Subject');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Subject was Successfully Deleted");
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
	public function delete_subject_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Subject');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Subjects Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}