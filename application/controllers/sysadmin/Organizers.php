<?php
/**
 * 
 */
class Organizers extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/organizers')
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
		$data['Page_name']='Organizers';
		$data['admin']=$admin;
		$data['organizers']=$this->Admin_model->get_organizers();
		$this->load->view('sysadmin/templates/header.php',$data);
		$this->load->view('sysadmin/templates/sidemenu.php',$data);
		$this->load->view('sysadmin/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer.php',$data);
	}
	public function Deactivate($id=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$user=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_organizer_id($user);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This user does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>2);
			$update=$this->Organizer_model->update_organizer($data_array,$user);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Organizer successfull updated');
				redirect($page);
			}
			else
			{
				$this->session->set_flashdata('message_error','Something went wrong and we could not process your request');
				redirect($page);
			}
		}
	}
	public function Activate($id=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$user=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_organizer_id($user);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This user does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>1);
			$update=$this->Organizer_model->update_organizer($data_array,$user);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Organizer successfully updated');
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
		$user=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_organizer_id($user);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This user does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$delete=$this->db->where('OrganizerId',$user)->delete('organizer');
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
	public function View($id=null,$page='sysadmin/view_user')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		$user=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_organizer_id($user);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This user does not exist or record not found in database');
            redirect($redirect_page);
		}
		else
		{
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
			$data['Page_name']='View User';
			$data['organizer']=$id_exists->row();
			$data['schools']=$this->Organizer_model->get_schools($user);
			$data['admin']=$admin;
			$this->load->view('sysadmin/templates/header.php',$data);
			$this->load->view('sysadmin/templates/sidemenu.php',$data);
			$this->load->view('sysadmin/templates/topmenu.php',$data);
			$this->load->view($page,$data);
			$this->load->view('sysadmin/templates/footer.php',$data);
		}
	}
	public function access_user()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('passcode', 'Pass Code', 'trim|required');
        $this->form_validation->set_rules('id', 'Organizer Id', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$password=html_escape($this->input->post('passcode'));
        	$user=html_escape($this->input->post('id'));
        	$user_exists=$this->db->from('organizer')->where('OrganizerId',$user)->where('SecurityCode',$password)->get();
        	if ($user_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message_error','User does not exist');
	            redirect($page);
        	}
        	else
        	{
        		$sess=sha1(time());
        		$update_sess = array('OrganSess' =>$sess);
				$update=$this->Organizer_model->update_organizer($update_sess,$user_exists->row()->OrganizerId);
				$sess_data  = array('Organid' =>$user_exists->row()->OrganizerId,'OrganSess'=>$sess);
				$this->session->set_userdata($sess_data);
				if ($update==true) 
				{
					$this->session->set_flashdata('message_success','Welcome to your dashboard.');
	            	redirect('account/index');
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
}