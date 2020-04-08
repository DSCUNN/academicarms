<?php 

class School_type extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "< You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/school_type')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['school_types']=$this->Organizer_model->get_school_type($organizerid);
		$data['Page_name']='School Type';
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/schooltype_footer.php',$data);
	}
	public function New_school_type()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'School Type', 'trim|required|alpha_numeric_spaces');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$type=strip_tags(html_escape($this->input->post('name')));
        	$type_exists=$this->Organizer_model->get_schooltype_type($type,$organizerid);
        	if ($type_exists->num_rows()<1) 
        	{
        		$data = array('School_type_name' =>$type,'OrganizerId'=>$organizerid,'Status'=>1,'Date_created'=>time());
        		$add=$this->Organizer_model->create_school_type($data);
        		if ($add==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "School Type Successfully Created.");
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
	        	$this->session->set_flashdata('message_error', "School Type already Exists");
	            redirect($page);
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
	public function update_school_type()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'School Type', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('id', 'School Type Id', 'trim|required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$type=strip_tags(html_escape($this->input->post('name')));
        	$id=strip_tags(html_escape($this->input->post('id')));
        	$status=strip_tags(html_escape($this->input->post('status')));
        	$type_exists=$this->db->select('*')->from('School_type')->where('School_type_name',$type)->where('OrganizerId',$organizerid)->where('School_type_id!=',$id)->get();
        	if ($type_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "School Type already exists");
		        redirect($page);
        	}
        	else
        	{
        		$data_update = array('School_type_name' =>$type,'Status'=>$status);
        		$update=$this->Organizer_model->update_school_type($data_update,$organizerid,$id);
        		if ($update==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "School Type Successfully Updated");
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
	public function delete_school_type()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'School Type Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$type_exists=$this->db->select('*')->from('School_type')->where('OrganizerId',$organizerid)->where('School_type_id',$id)->get();
        	if ($type_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "School type does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('School_type_id',$id)->where('OrganizerId',$organizerid)->delete('School_type');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "School Type Successfully Deleted");
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
	public function delete_school_type_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('School_type');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "School Types Successfully Deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
	public function get_schooltype_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$school_type=$this->Organizer_model->get_schooltype_id($id,$organizerid);
		$result=$school_type->result();
		echo json_encode($result);
	}
}