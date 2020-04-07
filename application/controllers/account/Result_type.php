<?php
defined('BASEPATH') OR exit('Access denied');

class Result_type extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/result_type')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['types']=$this->Organizer_model->types_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Result Types';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/type_footer',$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Semester', 'trim|required');
		$this->form_validation->set_rules('school', 'School', 'trim|required|numeric');		
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$type_exists=$this->db->select('*')->from('Result_type')->where('Name',$name)->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        	if ($type_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Result type Already exists in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Name' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Status'=>1,);
        		$add=$this->Organizer_model->create_result_type($data_insert);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Result Type was successfully added");
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
	public function view_type($id=null)
	{
		$pages='account/view_type';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school Result Types");
	        redirect($page);
		}

		$types=$this->db->select('*')->from('Result_type')->where('School_id',$schools->row()->School_id)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['types']=$types;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Result Types';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/type_footer',$data);	
	}
	public function Edit_type()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Grade', 'trim|required');
		$this->form_validation->set_rules('school', 'School', 'trim|required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		$this->form_validation->set_rules('id', 'Type Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	$id=html_escape($this->input->post('id'));
        	$school=html_escape($this->input->post('school'));
        	$grade_exists=$this->db->select('*')->from('Result_type')->where('Name',$name)->where('Type_id!=',$id)->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        	if ($grade_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Type Already exists in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Name' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Status'=>$status);
        		$add=$this->Organizer_model->update_result_type($data_insert,$id);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Result Type was successfully Updated");
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
	public function get_result_type_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$type=$this->Organizer_model->get_result_type_id($id,$organizerid);
		$result=$type->result();
		echo json_encode($result);
	}
	//delete emester
	public function delete_type()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Type Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$type_exists=$this->db->select('*')->from('Result_type')->where('OrganizerId',$organizerid)->where('Type_id',$id)->get();
        	if ($type_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Result Type does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Type_id',$id)->where('OrganizerId',$organizerid)->delete('Result_type');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Result type was Successfully Deleted");
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
	public function delete_type_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Result_type');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Result Types Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}