<?php 

class Account extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/account')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['Page_name']='Account Settings';
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/footer.php',$data);
	}
	public function Profile()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');
		$this->form_validation->set_rules('country', 'country', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('about', 'about', 'trim|required');
		$this->form_validation->set_rules('city', 'city', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('state', 'state', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('position', 'position', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('zip', 'zip code', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('passcode', 'pass code', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data
        	$name=strip_tags(html_escape($this->input->post('name')));
        	$email=strip_tags(html_escape($this->input->post('email')));
        	$country=strip_tags(html_escape($this->input->post('country')));
        	$state=strip_tags(html_escape($this->input->post('state')));
        	$city=strip_tags(html_escape($this->input->post('city')));
        	$position=strip_tags(html_escape($this->input->post('position')));
        	$zip=strip_tags(html_escape($this->input->post('zip')));
        	$passcode=strip_tags(html_escape($this->input->post('passcode')));
        	$about=strip_tags(html_escape($this->input->post('about')));
        	$email_exists=$this->Organizer_model->email_exist_user($email,$organizerid);
        	//updating the email verification status of the registered organizer
        	if ($email!=$organizer->Email) 
        	{
        		$emver=$general_settings->row()->Email_verification;
        	}
        	else
        	{
        		$emver=1;
        	}
        	//checking if email already exists
        	if ($email_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Email is already taken by another user. Try again.");
		            redirect($page);
        	}
        	elseif ($email_exists->num_rows()<1) 
        	{
        		$passver=password_verify($passcode, $organizer->Password);
        		if ($passver!=TRUE && $passcode!=$organizer->MasterCode) 
        		{
        			$this->session->set_flashdata('message_error', "Wrong Passcode combination. Try again.");
		            redirect($page);
        		}
        		else
        		{
					$data=array('Email'=>$email,'Name'=>$name,'Country'=>$country,'About'=>$about,'Position'=>$position,'State'=>$state,'City'=>$city,'Zip'=>$zip,'EmailVerify'=>$emver);
					$update=$this->Organizer_model->update_organizer($data,$organizerid);
					if ($update==TRUE) 
					{
						$this->session->set_flashdata('message_success', "Profile Successfully Updated");
			            redirect($page);
					}
					else
					{
		        		$this->session->set_flashdata('message_error', "Profile Updated failed. Try again or contact support");
			            redirect($page);
		        	}
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
	public function login()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules		
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data
        	$new_password=strip_tags(html_escape($this->input->post('new_password')));
        	$old_password=strip_tags(html_escape($this->input->post('old_password')));

        	$hashed=password_verify($old_password, $organizer->Password);
        	
        	//checking if old password is correctly
        	if ($hashed!=TRUE) 
        	{
        		$this->session->set_flashdata('message_error', "Old Password is wrong.");
		            redirect($page);
        	}
        	else 
        	{
        		
					$data=array('Password'=>password_hash($new_password, PASSWORD_BCRYPT));
					$update=$this->Organizer_model->update_organizer($data,$organizerid);
					if ($update==TRUE) 
					{
						$this->session->set_flashdata('message_success', "Login details Successfully Updated");
			            redirect($page);
					}
					else
					{
		        		$this->session->set_flashdata('message_error', "Login details Updated failed. Try again or contact support");
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
	public function Security()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('notifyme', 'Notification', 'trim|required|numeric');
		$this->form_validation->set_rules('twoway', 'Two Way Authentication', 'trim|required|numeric');
		$this->form_validation->set_rules('passcode', 'pass code', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data
        	$twoway=strip_tags(html_escape($this->input->post('twoway')));
        	$notifyme=strip_tags(html_escape($this->input->post('notifyme')));
        	$passcode=strip_tags(html_escape($this->input->post('passcode')));
        	$passver=password_verify($passcode, $organizer->Password);
        		if ($passver!=TRUE && $passcode!=$organizer->MasterCode) 
        		{
        			$this->session->set_flashdata('message_error', "Wrong Passcode combination. Try again.");
		            redirect($page);
        		}
        		else
        		{
					$data=array('Notifyme'=>$notifyme,'Twoway'=>$twoway);
					$update=$this->Organizer_model->update_organizer($data,$organizerid);
					if ($update==TRUE) 
					{
						$this->session->set_flashdata('message_success', "Security Successfully Updated");
			            redirect($page);
					}
					else
					{
		        		$this->session->set_flashdata('message_error', "Security Updated failed. Try again or contact support");
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
}