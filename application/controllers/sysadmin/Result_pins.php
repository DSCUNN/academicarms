<?php
/**
 * 
 */
class Result_pins extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/result_pins')
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
		$data['Page_name']='Result pins';
		$data['admin']=$admin;
		$data['result_pins']=$this->Admin_model->get_result_pins();
		$data['schools']=$this->Admin_model->get_schools();
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
		$id_exists=$this->Admin_model->get_result_pins_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Result pin does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>$status);
			$update=$this->Admin_model->update_result_pin($data_array,$id);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Result Pin successfull updated');
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
		$id_exists=$this->Admin_model->get_result_pins_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Result Pin does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$delete=$this->db->where('Pin_id',$id)->delete('result_pins');
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

}