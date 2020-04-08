<?php
defined('BASEPATH') OR exit('Access denied');

class Grade extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/grade')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['grades']=$this->Organizer_model->grade_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Grade';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/grade_footer',$data);
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Semester', 'trim|required');
		$this->form_validation->set_rules('school', 'School', 'trim|required|numeric');
		$this->form_validation->set_rules('min_score', 'Minimum Score', 'trim|required|numeric');
		$this->form_validation->set_rules('max_score', 'Maximum core', 'trim|required|numeric');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('point', 'Point', 'trim|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$min_score=html_escape($this->input->post('min_score'));
        	$max_score=html_escape($this->input->post('max_score'));
        	$comment=html_escape($this->input->post('comment'));
        	$point=html_escape($this->input->post('point'));
        	$grade_exists=$this->db->select('*')->from('Grade')->where('Name',$name)->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        	if ($grade_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Grade Already exists in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Name' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Status'=>1,'Min_Score'=>$min_score,'Max_Score'=>$max_score,'Comment'=>$comment,'Grade_point'=>$point);
        		$add=$this->Organizer_model->create_grade($data_insert);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Grade was successfully added");
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
	public function view_grade($id=null)
	{
		$pages='account/view_grades';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school Grades");
	        redirect($page);
		}

		$grades=$this->db->select('*')->from('Grade')->where('School_id',$schools->row()->School_id)->where('OrganizerId',$organizerid)->get();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['grades']=$grades;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='View Grades';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/grade_footer',$data);	
	}
	public function Edit_grade()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Grade', 'trim|required');
		$this->form_validation->set_rules('school', 'School', 'trim|required|numeric');
		$this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		$this->form_validation->set_rules('id', 'Grade Id', 'trim|required|numeric');
		$this->form_validation->set_rules('min_score', 'Minimum Score', 'trim|required|numeric');
		$this->form_validation->set_rules('max_score', 'Maximum core', 'trim|required|numeric');
		$this->form_validation->set_rules('comment', 'Comment', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('point', 'Point', 'trim|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$name=html_escape($this->input->post('name'));
        	$status=html_escape($this->input->post('status'));
        	$id=html_escape($this->input->post('id'));
        	$school=html_escape($this->input->post('school'));
        	$min_score=html_escape($this->input->post('min_score'));
        	$max_score=html_escape($this->input->post('max_score'));
        	$comment=html_escape($this->input->post('comment'));
        	$point=html_escape($this->input->post('point'));
        	$grade_exists=$this->db->select('*')->from('Grade')->where('Name',$name)->where('Grade_id!=',$id)->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
        	if ($grade_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Grade Already exists in this school");
	            redirect($page);
        	}
        	else
        	{
        			
        		$data_insert = array('Name' => $name,'School_id'=>$school,'OrganizerId'=>$organizerid,'Status'=>1,'Min_Score'=>$min_score,'Max_Score'=>$max_score,'Comment'=>$comment,'Grade_point'=>$point,'Status'=>$status);
        		$add=$this->Organizer_model->update_grade($data_insert,$id);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Grade was successfully Updated");
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
	//get semester details through ajax request
	public function get_grade_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$semester=$this->Organizer_model->get_grade_id($id,$organizerid);
		$result=$semester->result();
		echo json_encode($result);
	}
	//delete emester
	public function delete_grade()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Grade Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$grade_exists=$this->db->select('*')->from('Grade')->where('OrganizerId',$organizerid)->where('Grade_id',$id)->get();
        	if ($grade_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Grade does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Grade_id',$id)->where('OrganizerId',$organizerid)->delete('Grade');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Grade was Successfully Deleted");
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
	public function delete_grade_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Grade');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Grades Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}