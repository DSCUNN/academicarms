<?php
/**
 * 
 */
class Faq extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/faq')
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
		$data['Page_name']='Faqs';
		$data['admin']=$admin;
		$data['faq']=$this->Admin_model->get_faq();
		$data['category']=$this->Admin_model->get_faq_category();
		$this->load->view('sysadmin/templates/header',$data);
		$this->load->view('sysadmin/templates/sidemenu',$data);
		$this->load->view('sysadmin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer',$data);
	}
	public function set_status($id=null,$status=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$status=$this->security->xss_clean($this->uri->segment(5));
		$id_exists=$this->Admin_model->get_faq_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Question does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>$status);
			$update=$this->Admin_model->update_faq($data_array,$id);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Question successfully updated');
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
		$id_exists=$this->Admin_model->get_faq_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Question does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$delete=$this->db->where('Faq_id',$id)->delete('faq');
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
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('answer', 'Answer', 'trim|required');
        $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$answer=html_escape($this->input->post('answer'));
        	$category=html_escape($this->input->post('category'));
        	$exists=$this->db->from('faq')->where('Question',$name)->where('Category',$category)->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','Question already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('Question' =>$name,'Status'=>1,'Answer'=>$answer,'Category'=>$category);
				$add=$this->Admin_model->create_faq($data_array);
				if ($add==true) 
				{
					$this->session->set_flashdata('message_success','Question Successfully added');
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
        $this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
        $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$answer=html_escape($this->input->post('answer'));
        	$category=html_escape($this->input->post('category'));
        	$id=html_escape($this->input->post('id'));
        	$exists=$this->db->from('faq')->where('Question',$name)->where('Faq_id!=',$id)->where('Category',$category) ->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','Category already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('Question' =>$name,'Answer'=>$answer,'Category'=>$category);
				$update=$this->Admin_model->update_faq($data_array,$id);
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
	public function get_faq_id($id)
	{
		$results=$this->Admin_model->get_faq_id($id);
		$results=$results->result();
		echo json_encode($results);
	}
}