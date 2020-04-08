<?php
/**
 * 
 */
class Payment_methods extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/payment_methods')
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
		$data['Page_name']='Payment Methods';
		$data['admin']=$admin;
		$data['payment_methods']=$this->Admin_model->get_payment_methods();
		$this->load->view('sysadmin/templates/header',$data);
		$this->load->view('sysadmin/templates/sidemenu',$data);
		$this->load->view('sysadmin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer',$data);
	}
	public function edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('merchant_id', 'Merchant Id', 'trim');
        $this->form_validation->set_rules('private_key', 'Private Key', 'trim');
        $this->form_validation->set_rules('public_key', 'Public Key', 'trim');
        $this->form_validation->set_rules('url', 'Web Url', 'trim');
        $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=$this->security->xss_clean($this->input->post('name'));
        	$private_key=$this->security->xss_clean($this->input->post('private_key'));
        	$public_key=$this->security->xss_clean($this->input->post('public_key'));
        	$merchant_id=$this->security->xss_clean($this->input->post('merchant_id'));
        	$id=html_escape($this->input->post('id'));
        	$url=html_escape($this->input->post('url'));
        	$exists=$this->db->from('paymentmethod')->where('MethodName',$name)->where('MethodId!=',$id)->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','payment Method already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('MethodName' =>$name,'Private_key'=>$private_key,'Public_key'=>$public_key,'Merchant_id'=>$merchant_id,'Web_Hook'=>$url);
				$update=$this->Admin_model->update_payment_method($data_array,$id);
				if ($update==true) 
				{
					$this->session->set_flashdata('message_success','Pament Method Successfully Updated');
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
	public function get_payment_method_id($id)
	{
		$results=$this->Admin_model->get_payment_method_id($id);
		$results=$results->result();
		echo json_encode($results);
	}
	public function set_status($id=null,$status=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$status=$this->security->xss_clean($this->uri->segment(5));
		$id_exists=$this->Admin_model->get_payment_method_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Payment method does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>$status);
			$update=$this->Admin_model->update_payment_method($data_array,$id);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Payment method successfully updated');
				redirect($page);
			}
			else
			{
				$this->session->set_flashdata('message_error','Something went wrong and we could not process your request');
				redirect($page);
			}
		}
	}
}