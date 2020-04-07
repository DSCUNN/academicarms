<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index($page='register')
	{
		if ($this->session->userdata('OrganSess'))
		{
            redirect(base_url().'account/index');
		}
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Account Creation';
		$this->load->view($page,$data);
	}
	public function create_account()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('password_confirmation', 'Password Confirmation', 'trim|required|matches[password]');
		if ($this->form_validation->run() == TRUE)
        {
        	//Escaping html entities in message.
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$username=html_escape($this->input->post('username'));
        	$password=html_escape($this->input->post('password'));

        	$site_title=$general_settings->row()->Site_name;
        	$verify=$general_settings->row()->Email_verification;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$general_settings->row()->Site_logo;
			$maintenance=$general_settings->row()->Maintenance;
			$registration=$general_settings->row()->Site_registration;

			//processing request
			$email_exists=$this->Organizer_model->email_real($email);
			$username_exists=$this->Organizer_model->username_real($username);
			if ($maintenance==1) 
			{
				$this->session->set_flashdata('message_error', "We are currently undergoing a site maintenance and will be back shortly.");
	        	redirect($page);
			}
			elseif ($registration!=1) 
			{
				$this->session->set_flashdata('message_error', "Registration is currently closed.");
	        	redirect($page);
			}
			elseif ($email_exists->num_rows()>0) 
			{
				$this->session->set_flashdata('message_error', "Email is already being used by another person.");
	        	redirect($page);
			}
			elseif ($username_exists->num_rows()>0) 
			{
				$this->session->set_flashdata('message_error', "Username is already being used by another person.");
	        	redirect($page);
			}
			else
			{
				/*Generate Code for verifying user email*/
	        	$verifyc = rand(100000,999999);
	        	//getting length of mastercode and securitycode
			    $master_length=$general_settings->row()->Mastercode_length;
			    $security_length=$general_settings->row()->Securitycode_length;
	            //getting mastercode combination
			    $master_char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!?|.,';
			    $security_char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    //shuffling
	            $mastercode= substr(str_shuffle($master_char), 0,$master_length);
	            $securitycode= substr(str_shuffle($security_char), 0,$security_length);
	            if ($verify==2) 
	            {
            		$comment='An email has been sent to you containing a six digit code for verifying your email address. If you did not see it in your inbox, check your spam page and white list us.';
            		$verifyc=$verifyc;
	            }elseif ($verify==1) 
	            {
	            	$comment='Continue to Login.';
	            	$verifyc='';
	            }
				$link = base_url().'assets/dashboard/logo/';
				$links=base_url();
				$linkss=base_url();
				$image=$link.$logo;
				$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
	            $body .= "<table style='width: 100%;'>";
	            $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
	            $body .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
	            $body .= "</td></tr></thead><tbody><tr>";
	            $body.="Your Email Has been used to register on our platform. This email contains a six digit code to use to verify that you actually did register on our platform. You can ignore if you did not make this request.<br><br>";
	            $body.="<p><b>$verifyc</b></p>";
	            $body .= "</tr>";
	            $body .= "</tbody></table>";
	            $body .= "</body></html>";

				//processing data into an array
				$data_to_insert  = array('Name' =>$name ,'Email'=>$email,'Username'=>$username,'Password'=>password_hash($password, PASSWORD_BCRYPT),'EmailVerify'=>$verify,'EmailVerifyCode'=>$verifyc,'Twoway'=>$general_settings->row()->Site_twoway,'Notifyme'=>$site_notify,'Active_package'=>1,'Status'=>1,'MasterCode'=>$mastercode,'SecurityCode'=>$securitycode);
	        	$data=html_escape($data_to_insert);
	        	$add=$this->Organizer_model->create_organizer($data);
	        	if ($add==TRUE) 
	        	{
				    if ($verify==2) 
				    {
				    	$this->session->set_userdata('Email',$email);
						//sending email
					    $send=$this->email->from($webmail, $site_title)->to($email)->subject('Account Verification')->message($body)->set_mailtype('html')->send();
			        	$this->session->set_flashdata('message', "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>Registration was successful. $comment</span></div>");
			        	redirect('register/verify_email');
				    }
				    $this->session->set_flashdata('message_success', "Your account has successfully been created. Login to continue");
			        redirect('login');
			    }
			    else
			    {
			    	$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
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
	public function verify_email($page='email_verify')
	{
		if (!$this->session->userdata('Email')) 
		{
        	$this->session->set_flashdata('message_error', "You do not have the clearance to view this page.");
        	redirect('login');
		}
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('code', 'Email Code', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$email=$this->session->userdata('Email');
        	//Escaping html entities in message.
        	$code=html_escape($this->input->post('code'));
        	//processing request
			$code_exists=$this->Organizer_model->verify_code_real($email,$code);
			if ($code_exists->num_rows()>0) 
			{
				$data_update = array('EmailVerifyCode' =>'','EmailVerify'=>1);
				$update=$this->Organizer_model->update_organizer($data_update,$code_exists->row()->OrganizerId);
				if ($update==TRUE) 
				{
					$this->session->unset_userdata('Email');//removing the session to avoid unauthorized access.
					$this->session->set_flashdata('message_success', "Your Account has been verified. Login to continue");
        			redirect('login');
				}
				else
				{
					$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
        			redirect('login');
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "This code does not exist");
        		redirect('login');
			}
        }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Emai Verification';
		$this->load->view($page,$data);
	}
}