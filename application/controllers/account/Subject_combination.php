<?php
defined('BASEPATH') OR exit('Access denied');

class Subject_combination extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/subject_combination')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['combinations']=$this->Organizer_model->get_subject_combination_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Subject Combination';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/subjectcombination_footer',$data);
	}
	public function Create_combination()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('school', 'School', 'trim|numeric|required');
		$this->form_validation->set_rules('combination[]', 'Subjects', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
        	$classess=array();
        	$class=html_escape($this->input->post('class'));
        	$school=html_escape($this->input->post('school'));
        	$combination=html_escape($this->input->post('combination'));
        	for ($i=0; $i < count($combination); $i++) 
        	{ 
        		$subject_exists=$this->db->select('*')->from('Subject_combination')->where('Subject',$combination[$i])->where('Class',$class)->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        		if ($subject_exists->num_rows()>0) 
        		{
        			$this->session->set_flashdata('message_error', "Subject Already Asigned to Class");
	            	redirect($page);
        		}
        		else
        		{
        			
        			$data_insert = array('Subject' => $combination[$i],'School_id'=>$school,'OrganizerId'=>$organizerid,'Class'=>$class,'Status'=>1);
        			$add=$this->Organizer_model->create_subject_combination($data_insert);
        		}
        	}
        	if ($add==TRUE) 
        	{
        		$this->session->set_flashdata('message_success', "Subjects successfully added to class");
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
	public function view_subject_class($id=null)
	{
		$pages='account/view_combination_class';
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
		$combination=$this->db->select('*')->from('Subject_combination')->where('School_id',$schools->row()->School_id)->group_by('Class')->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['combinations']=$combination;
		$data['Page_name']='View Subjects';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/subjectcombination_footer',$data);	
	}
	public function view_combinations($id=null)
	{
		$pages='account/view_combinations';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$classes=$this->db->select('*')->from('Classes')->where('ClassRef',$id)->where('OrganizerId',$organizerid)->get();
		if ($classes->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested Class Subjects");
	        redirect($page);
		}
		$combination=$this->db->select('*')->from('Subject_combination')->where('Class',$classes->row()->Class_id)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['combinations']=$combination;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Subjects';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/subject_footer',$data);	
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
	//delete subject combination
	public function delete_combination()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Combination Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$combination_exists=$this->db->select('*')->from('Subject_combination')->where('OrganizerId',$organizerid)->where('Combination_id',$id)->get();
        	if ($combination_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Combination does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Combination_id',$id)->where('OrganizerId',$organizerid)->delete('Subject_combination');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Combination was Successfully Deleted");
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
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Subject_combination');
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