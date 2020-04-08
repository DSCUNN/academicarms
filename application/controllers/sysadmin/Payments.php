<?php
/**
 * 
 */
class Payments extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/payments')
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
		$data['Page_name']='Payments';
		$data['admin']=$admin;
		$data['payments']=$this->Admin_model->get_payments();
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
		$id_exists=$this->Admin_model->get_payment_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Payment does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$organizer=$this->Admin_model->get_organizer_id($id_exists->row()->OrganizerId);
			$balance=$organizer->row()->Balance;
			$new_balance=$id_exists->row()->Amount_paid+$balance;
			
			$data_array = array('Payment_Status' =>$status);
			$update=$this->Admin_model->update_payment($data_array,$id);
			if ($update==true) 
			{
				if ($status==1) 
				{
					$data_organizer = array('Balance' => $new_balance);
					$this->Organizer_model->update_organizer($data_organizer,$organizer->row()->OrganizerId);
				}
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
	public function delete($id=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_payment_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Payment does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			
			$delete=$this->db->where('Payment_id',$id)->delete('payments');
			if ($delete==true) 
			{
				$this->session->set_flashdata('message_success','Payment method successfully deleted');
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