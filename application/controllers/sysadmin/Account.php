<?php
/**
 * 
 */
class Account extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/account')
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
		$data['Page_name']='Account Setting';
		$data['admin']=$admin;
		$this->load->view('sysadmin/templates/header',$data);
		$this->load->view('sysadmin/templates/sidemenu',$data);
		$this->load->view('sysadmin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer',$data);
	}
	public function profile()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//retrieving data from stored sessions
		$admin_sess=$this->session->userdata('AdminSess');
		$admin_id=$this->session->userdata('Admin_id');
		$admin=$this->Admin_model->admin_details($admin_id,$admin_sess);
		//Set Form Validation Rules
        $this->form_validation->set_rules('name', ' Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('notifyme', 'Notification', 'trim|required|numeric');
        $this->form_validation->set_rules('twoway', 'Two Factor Authentication', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {

        	$name=$this->security->xss_clean($this->input->post('name'));
        	$notifyme=$this->security->xss_clean($this->input->post('notifyme'));
        	$email=$this->security->xss_clean($this->input->post('email'));
        	$twoway=$this->security->xss_clean($this->input->post('twoway'));

        	$data_array = array('Name' =>$name,'Email'=>$email,'Twoway'=>$twoway,'Notifyme'=>$notifyme);
			$update=$this->Admin_model->update_admin($data_array,$admin->admin_id);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Profile Details Successfully updated');
	            redirect($page);
			}
			else
			{
				$this->session->set_flashdata('message_error','Something Went wrong.');
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
	public function Login()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//retrieving data from stored sessions
		$admin_sess=$this->session->userdata('AdminSess');
		$admin_id=$this->session->userdata('Admin_id');
		$admin=$this->Admin_model->admin_details($admin_id,$admin_sess);
		//Set Form Validation Rules
        $this->form_validation->set_rules('old_password', ' Old Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
		if ($this->form_validation->run() == TRUE)
        {

        	$old_password=$this->security->xss_clean($this->input->post('old_password'));
        	$new_password=$this->security->xss_clean($this->input->post('new_password'));
        	//check if old password is valid
        	$hashed=password_verify($old_password, $admin->Password);
        	if ($hashed==true) 
        	{
        		$data_array = array('Password' =>password_hash($new_password, PASSWORD_BCRYPT));
				$update=$this->Admin_model->update_admin($data_array,$admin->admin_id);
				if ($update==true) 
				{
					$this->session->set_flashdata('message_success','Login Successfully updated');
		            redirect($page);
				}
				else
				{
					$this->session->set_flashdata('message_error','Something Went wrong.');
		            redirect($page);
				}
        	}
        	else
        	{
        		$this->session->set_flashdata('message_error','Old Password is wrong');
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
}