<?php
/**
 * 
 */
class Faq_category extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/faq_category')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('AdminSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		//retrieving data from stored sessions
		$admin_sess=$this->session->userdata('AdminSess');
		$admin_id=$this->session->userdata('Admin_id');
		$admin=$this->Admin_model->admin_details($admin_id,$admin_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Faq Category';
		$data['admin']=$admin;
		$data['faq_category']=$this->Admin_model->get_faq_category();
		$this->load->view('sysadmin/templates/header.php',$data);
		$this->load->view('sysadmin/templates/sidemenu.php',$data);
		$this->load->view('sysadmin/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer.php',$data);
	}
	public function set_status($id=null,$status=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$status=$this->security->xss_clean($this->uri->segment(5));
		$id_exists=$this->Admin_model->get_faq_category_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Category does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>$status);
			$update=$this->Admin_model->update_faq_category($data_array,$id);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Category successfull updated');
				redirect($page);
			}
			else
			{
				$this->session->set_flashdata('message_error','Something went wrong and we could not process your request');
				redirect($page);
			}
		}
	}
	public function delete($id=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_faq_category_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Category does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$delete=$this->db->where('Category_id',$id)->delete('faq_category');
			if ($delete==true) 
			{
				$this->session->set_flashdata('message_success','Successfully Removed');
				redirect($page);
			}
			else
			{
				$this->session->set_flashdata('message_error','Something went wrong and we could not process your request');
				redirect($page);
			}
		}
	}
	public function create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$exists=$this->db->from('faq_category')->where('Name',$name)->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','Category already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('Name' =>$name,'Status'=>1);
				$add=$this->Admin_model->create_faq_category($data_array);
				if ($add==true) 
				{
					$this->session->set_flashdata('message_success','Category Successfully added');
	            	redirect($page);
				}
				else
				{
					$this->session->set_flashdata('message_error','Something Went wrong.');
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
	public function edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$id=html_escape($this->input->post('id'));
        	$exists=$this->db->from('faq_category')->where('Name',$name)->where('Category_id!=',$id)->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','Category already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('Name' =>$name,'Status'=>1);
				$update=$this->Admin_model->update_faq_category($data_array,$id);
				if ($update==true) 
				{
					$this->session->set_flashdata('message_success','Category Successfully Updated');
	            	redirect($page);
				}
				else
				{
					$this->session->set_flashdata('message_error','Something Went wrong.');
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
	public function get_faq_category_id($id)
	{
		$results=$this->Admin_model->get_faq_category_id($id);
		$results=$results->result();
		echo json_encode($results);
	}
}