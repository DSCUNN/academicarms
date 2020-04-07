<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index($page='login')
	{
		if ($this->session->userdata('OrganSess'))
		{
            redirect(base_url().'account/index');
		}
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Account Signin';
		$this->load->view($page,$data);
	}
	public function authenticate()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		if ($this->form_validation->run() == TRUE)
        {
        	$email=html_escape($this->input->post('email'));
        	$password=html_escape($this->input->post('password'));

        	$site_title=$general_settings->row()->Site_name;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$general_settings->row()->Site_logo;
			$maintenance=$general_settings->row()->Maintenance;

        	//processing request
        	if ($maintenance==1) 
        	{
        		$this->session->set_flashdata('message_error', "We are currently undergoing a site maintenance and will be back shortly.");
	        	redirect($page);
        	}
			$email_exists=$this->Organizer_model->email_real($email);
			if ($email_exists->num_rows()>0) 
			{
				$hashed=password_verify($password,$email_exists->row()->Password);
				if ($hashed==TRUE) 
				{
					if ($email_exists->row()->Status!=1) 
					{
						$this->session->set_flashdata('message_error', "You have been banned from this system. Contact us for more information");
	        			redirect($page);
					}
					else
					{
						$verify=$email_exists->row()->EmailVerify;
						$twoway=$email_exists->row()->Twoway;
						$notifyme=$email_exists->row()->Notifyme;
						$sess=sha1(time());
						/*Generate Code for verifying user email*/
			        	$verifyc = rand(100000,999999);
			            $verifycode=sha1($verifyc);

						$link = base_url().'assets/dashboard/logo/';
						$links=base_url();
						$linkss=base_url();
						$image=$link.$logo;
						//for email verification
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
			            //for twoway verification
			            $body1 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
			            $body1.= "<table style='width: 100%;'>";
			            $body1 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
			            $body1 .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
			            $body1 .= "</td></tr></thead><tbody><tr>";
			            $body1.="There is an attempt to login to your account. Use the code below to authenticate this login request. You can ignore if you did not make this request.<br><br>";
			            $body1.="<p><b>$verifyc</b></p>";
			            $body1 .= "</tr>";
			            $body1 .= "</tbody></table>";
			            $body1 .= "</body></html>";
			            
			            if ($verify==2) 
					    {
					    	$this->session->set_userdata('Email',$email);

					    	$update_sess = array('EmailVerifyCode' =>$verifyc);
					    	$this->Organizer_model->update_organizer($update_sess,$email_exists->row()->OrganizerId);
							//sending email
						    $send=$this->email->from($webmail, $site_title)->to($email)->subject('Account Verification')->message($body)->set_mailtype('html')->send();
				        	$this->session->set_flashdata('message_error', "Your email is still unverified. Check your mail box or spam box for your verification code.");
				        	redirect('register/verify_email');
					    }
					    elseif ($twoway==1) 
					    {
					    	$this->session->set_userdata('Email',$email);

					    	$update_sess = array('Twoway_code'=>$verifyc);
					    	$this->Organizer_model->update_organizer($update_sess,$email_exists->row()->OrganizerId);
							//sending email
						    $send=$this->email->from($webmail, $site_title)->to($email_exists->row()->Email)->subject('Login Authentication')->message($body1)->set_mailtype('html')->send();

				        	$this->session->set_flashdata('message_success', "A code has been sent to your mail for login Authentication.");
				        	redirect('login/twoway');
					    }
					    else 
					    {
					    	$update_sess = array('OrganSess' =>$sess);
					    	$this->Organizer_model->update_organizer($update_sess,$email_exists->row()->OrganizerId);

					    	$sess_data  = array('Organid' =>$email_exists->row()->OrganizerId,'OrganSess'=>$sess);
					    	$this->session->set_userdata($sess_data);
					    	if($notifyme==1)
					    	{
					    		//for login notification
					            $body2 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
					            $body2 .= "<table style='width: 100%;'>";
					            $body2 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
					            $body2 .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
					            $body2 .= "</td></tr></thead><tbody><tr>";
					            $body2.="Your account has been accessed. You can ignore if you are the person, else we advise you login to your account and change your .<br><br>";
					            $body2 .= "</tr>";
					            $body2 .= "</tbody></table>";
					            $body2 .= "</body></html>";
								//sending email
							    $send=$this->email->from($webmail, $site_title)->to($email_exists->row()->Email)->subject('Login Notification')->message($body2)->set_mailtype('html')->send();
							}
				        	$this->session->set_flashdata('message_success', "Login was successful. Welcome to your dashboard");
				        	redirect('account/index');
					    }
					}
				}
				else
				{
					$this->session->set_flashdata('message_error', "Email and Password combination does not match");
	        		redirect($page);
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "Email Does not exist");
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
	public function forgotpassword($page='forgotpassword')
	{
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Account Recovery';
		//Set Form Validation Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == TRUE)
        {
        	$site_title=$general_settings->row()->Site_name;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$general_settings->row()->Site_logo;

        	//Escaping html entities in message.
        	$email=html_escape($this->input->post('email'));
        	//processing request
			$email_exists=$this->Organizer_model->email_real($email);
			if ($email_exists->num_rows()>0) 
			{
				/*Generate Code for verifying user email*/
			    $verifyc = rand(100000,999999);
			    $verifyc2 = rand(100000,999999);
				$data_update = array('ResetCode' =>$verifyc);
				$update=$this->Organizer_model->update_organizer($data_update,$email_exists->row()->OrganizerId);
				if ($update==TRUE) 
				{
					$sess_datam = array('Email' =>$email_exists->row()->Email);
					$this->session->set_userdata($sess_datam);//removing the session to avoid unauthorized access.
					$this->session->set_flashdata('message_success', "A code has ben sent to your mail to verify your rquest.");
					$notifyme=$email_exists->row()->Notifyme;

					//for password change
					    $body2 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
					    $body2 .= "<table style='width: 100%;'>";
					    $body2 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
					    $body2 .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
					    $body2 .= "</td></tr></thead><tbody><tr>";
					    $body2.="A request to chang your account password has been recieved on our platform. Use the code below to verify your request or ignore if you did not make this request. This code will be rendered useless in an hour.<br><br>";
					    $body2.="<p> Your password reset code is <b>$verifyc</b> </p>";
					    $body2 .= "</tr>";
					    $body2 .= "</tbody></table>";
					    $body2 .= "</body></html>";
								//sending email
						$send=$this->email->from($webmail, $site_title)->to($email_exists->row()->Email)->subject('Password Reset Request')->message($body2)->set_mailtype('html')->send();
					$this->session->set_userdata($sess_data);
        			redirect('login/email_verify');
				}
				else
				{
					$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
        			redirect('login/forgotpassword');
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "This Email does not exist");
        		redirect('login/forgotpassword');
			}
        }
		$this->load->view($page,$data);
	}
	public function email_verify($page='email_verify')
	{
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Account Recovery';
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
			$code_exists=$this->Organizer_model->reset_code_real($email,$code);
			if ($code_exists->num_rows()>0) 
			{
				$data_update = array('ResetCode' =>'');
				$update=$this->Organizer_model->update_organizer($data_update,$code_exists->row()->OrganizerId);
				if ($update==TRUE) 
				{
					$this->session->set_flashdata('message_success', "Your Account has been verified. Proceed to change your password");
        			redirect('login/resetpassword');
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
		$this->load->view($page,$data);
	}
	public function twoway($page='twoway')
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
        	$site_title=$general_settings->row()->Site_name;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$general_settings->row()->Site_logo;
        	$email=$this->session->userdata('Email');
        	//Escaping html entities in message.
        	$code=html_escape($this->input->post('code'));
        	//processing request
			$code_exists=$this->Organizer_model->verify_codelogin_real($email,$code);
			if ($code_exists->num_rows()>0) 
			{
				$sess=sha1(time());
				$data_update = array('Twoway_code' =>'','OrganSess'=>$sess);
				$update=$this->Organizer_model->update_organizer($data_update,$code_exists->row()->OrganizerId);
				if ($update==TRUE) 
				{
					$this->session->unset_userdata('Email');//removing the session to avoid unauthorized access.
					$sess_data  = array('Organid' =>$code_exists->row()->OrganizerId,'OrganSess'=>$sess);
					$this->session->set_flashdata('message_success', "You have successfully authorized your login.");
					$notifyme=$code_exists->row()->Notifyme;
					if($notifyme==1)
					{
					    //for login notification
					    $body2 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
					    $body2 .= "<table style='width: 100%;'>";
					    $body2 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
					    $body2 .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
					    $body2 .= "</td></tr></thead><tbody><tr>";
					    $body2.="Your account has been accessed. You can ignore if you are the person, else we advise you login to your account and change your .<br><br>";
					    $body2 .= "</tr>";
					    $body2 .= "</tbody></table>";
					    $body2 .= "</body></html>";
								//sending email
						$send=$this->email->from($webmail, $site_title)->to($code_exists->row()->Email)->subject('Login Notification')->message($body2)->set_mailtype('html')->send();
					}
					$this->session->set_userdata($sess_data);
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
		$data['Page_name']='Login Authentication';
		$this->load->view($page,$data);
	}
	public function resetpassword($page='resetpassword')
	{
		if (!$this->session->userdata('Email')) 
		{
        	$this->session->set_flashdata('message_error', "You do not have the clearance to view this page.");
        	redirect('login');
		}
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Repeat New Password', 'trim|required|min_length[8]|matches[new_password]');
		if ($this->form_validation->run() == TRUE)
        {
        	$site_title=$general_settings->row()->Site_name;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$general_settings->row()->Site_logo;
        	$email=$this->session->userdata('Email');
        	//Escaping html entities in message.
        	$new_password=html_escape($this->input->post('new_password'));

        	//processing request
			$email_exists=$this->Organizer_model->email_real($email);
			if ($email_exists->num_rows()>0) 
			{
				$sess=sha1(time());
				$data_update = array('Password'=>password_hash($new_password, PASSWORD_BCRYPT));
				$update=$this->Organizer_model->update_organizer($data_update,$email_exists->row()->OrganizerId);
				if ($update==TRUE) 
				{
					$this->session->unset_userdata('Email');//removing the session to avoid unauthorized access.
					$this->session->set_flashdata('message_success', "You have successfully changed your login details.");
					$notifyme=$email_exists->row()->Notifyme;
					if($notifyme==1)
					{
					    //for login notification
					    $body2 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
					    $body2 .= "<table style='width: 100%;'>";
					    $body2 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
					    $body2 .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
					    $body2 .= "</td></tr></thead><tbody><tr>";
					    $body2.="Your account login details has been changed. If you did not make this change, do not hesistate to contact us for help in retrieveing your account.<br><br>";
					    $body2 .= "</tr>";
					    $body2 .= "</tbody></table>";
					    $body2 .= "</body></html>";
								//sending email
						$send=$this->email->from($webmail, $site_title)->to($email_exists->row()->Email)->subject('Password Change')->message($body2)->set_mailtype('html')->send();
					}
        			redirect('login');
				}
				else
				{
					$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
        			redirect('login/resetpassword');
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "This Email does not exist");
        		redirect('login/forgotpassword');
			}
        }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Reset Password';
		$this->load->view($page,$data);
	}
}