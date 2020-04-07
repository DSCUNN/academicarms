<?php

/**
 * 
 */
class Login extends CI_Controller
{

	public function index($page='teachers/login')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		$school_url=$this->uri->segment(2);
		$school_exists=$this->session->userdata('school');
		if ($school_exists->School_url!=$school_url) 
		{
			redirect($redirect_page);
		}
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->School_name;
		$data['Page_name']='Account Signin';
		$data['school_exists']=$school_exists;
		$this->load->view($page,$data);
	}
	public function authenticate()
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		$school_url=$this->uri->segment(1);
		$school_exists=$this->session->userdata('school');
		$general_settings=$this->Web_model->general_settings();
		if ($school_exists->School_url!=$school_url) 
		{
			$this->session->set_flashdata('message_error','You are not permitted to perform this operation.');
			redirect($redirect_page);
		}
		//check if form was submitted
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|required');
		if ($this->form_validation->run()==true) 
		{
			//sanitize inputs
			$email=$this->security->xss_clean($this->input->post('email'));
			$password=$this->security->xss_clean($this->input->post('password'));

			//check if site under maintenance
			if ($general_settings->row()->Maintenance==1)
			{
				$this->session->set_flashdata('message_error','YLogin process failed due to ongoing site maintenance.');
				redirect($redirect_page);
			}
			else
			{

				//check if email exists
				$email_exists=$this->Teacher_model->email_real_school($email,$school_exists->School_id);
				if ($email_exists->num_rows()>0) 
				{
					$url=$school_exists->school_url;
					//check for password matching
					$hashed=password_verify($password,$email_exists->row()->Password);
					if ($hashed==true) 
					{
						if ($email_exists->row()->Status!=1) 
						{
							$this->session->set_flashdata('message_error','Your account has been suspended. Contact your school administrator details.');
							redirect($redirect_page);
						}
						else
						{
							$sess=sha1(time());
							$data_sess = array('TeacherSess' =>$sess,'Teacherid'=>$email_exists->row()->Teacher_id,'Class'=>$email_exists->row()->Class,'School_organ'=>$email_exists->row()->OrganizerId,'School_teacher'=>$email_exists->row()->School_id);
							$data_insert = array('TeacherSess' => $sess);

							$update=$this->Teacher_model->update_teacher($data_insert,$email_exists->row()->Teacher_id);
							$set_sess=$this->session->set_userdata($data_sess);
							if ($update==true && $this->session->has_userdata('TeacherSess')) 
							{
								$this->session->set_flashdata('message_success','Your Login was successful. Welcome to your dashboard.');
								redirect("teachers/account");
							}
							else
							{
								$this->session->set_flashdata('message_error','Login process failed. Contact school administrator for more details.');
								redirect($redirect_page);
							}
						}
					}
					else
					{
						$this->session->set_flashdata('message_error','Email and Password combination does not match.');
						redirect($redirect_page);
					}
				}
				else
				{
					$this->session->set_flashdata('message_error','Email Does not exist in school record');
					redirect($redirect_page);
				}
			}
		}
		else
		{
			$errors=validation_errors();
		    $this->session->set_flashdata('message', "<div class=\"alert alert-warning alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span>$errors</span></div>");
		    redirect($redirect_page);
		}
	}
	public function forgotpassword($page='forgotpassword')
	{
		$school_exists=$this->session->userdata('school');
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->School_name;
		$data['Page_name']='Account Recovery';
		$url_base=base_url().'schools/'.$school_exists->School_url;
		//Set Form Validation Rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == TRUE)
        {
        	$site_title=$school_exists->School_name;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$school_exists->School_logo;

        	//Escaping html entities in message.
        	$email=html_escape($this->input->post('email'));
        	//processing request
			$email_exists=$this->Teacher_model->email_real($email);
			if ($email_exists->num_rows()>0) 
			{
				/*Generate Code for verifying user email*/
			    $verifyc = rand(100000,999999);
			    $verifyc2 = rand(100000,999999);
				$data_update = array('Email_code' =>$verifyc);
				$update=$this->Teacher_model->update_teacher($data_update,$email_exists->row()->Teacher_id);
				if ($update==TRUE) 
				{
					$sess_datam = array('Email' =>$email_exists->row()->Email);
					$this->session->set_userdata($sess_datam);//removing the session to avoid unauthorized access.
					$this->session->set_flashdata('message_success', "A code has ben sent to your mail to verify your rquest.");

					//for password change
					    $body2 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
					    $body2 .= "<table style='width: 100%;'>";
					    $body2 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
					    $body2 .= "<a href='{$url_base}'><img src='{$image}' style='width: 500px;' alt=''></a><br><br>";
					    $body2 .= "</td></tr></thead><tbody><tr>";
					    $body2.="A request to chang your account password has been recieved on our platform. Use the code below to verify your request or ignore if you did not make this request. This code will be rendered useless in an hour.<br><br>";
					    $body2.="<p> Your password reset code is <b>$verifyc</b> </p>";
					    $body2 .= "</tr>";
					    $body2 .= "</tbody></table>";
					    $body2 .= "</body></html>";
								//sending email
						$send=$this->email->from($webmail, $site_title)->to($email_exists->row()->Email)->subject('Password Reset Request')->message($body2)->set_mailtype('html')->send();
					$this->session->set_userdata($sess_data);
        			redirect('teachers/login/email_verify');
				}
				else
				{
					$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
        			redirect('teachers/login/forgotpassword');
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "This Email does not exist");
        		redirect('teachers/login/forgotpassword');
			}
        }
		$this->load->view($page,$data);
	}
	public function email_verify($page='email_verify')
	{
		$school_exists=$this->session->userdata('school');
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->School_name;
		$data['Page_name']='Account Recovery';
		$url=base_url().'schools/'.$school_exists->School_url.'/teachers';
		if (!$this->session->userdata('Email')) 
		{
        	$this->session->set_flashdata('message_error', "You do not have the clearance to view this page.");
        	redirect($url);
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
			$code_exists=$this->Teacher_model->reset_code_real($email,$code);
			if ($code_exists->num_rows()>0) 
			{
				$data_update = array('Email_code' =>'');
				$update=$this->Teacher_model->update_teacher($data_update,$code_exists->row()->Teacher_id);
				if ($update==TRUE) 
				{
					$this->session->set_flashdata('message_success', "Your Account has been verified. Proceed to change your password");
        			redirect('teachers/login/resetpassword');
				}
				else
				{
					$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
        			redirect('teachers/login/forgotpassword');
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "This code does not exist");
        		redirect('teachers/login/forgotpassword');
			}
        }
		$this->load->view($page,$data);
	}
	public function resetpassword($page='resetpassword')
	{
		$school_exists=$this->session->userdata('school');
		$url=base_url().'schools/'.$school_exists->School_url.'/teachers';
		$url_base=base_url().'schools/'.$school_exists->School_url;
		if (!$this->session->userdata('Email')) 
		{
        	$this->session->set_flashdata('message_error', "You do not have the clearance to view this page.");
        	redirect($url);
		}
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Repeat New Password', 'trim|required|min_length[8]|matches[new_password]');
		if ($this->form_validation->run() == TRUE)
        {
        	$site_title=$school_exists->School_name;
        	$site_notify=$general_settings->row()->Site_notification;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$school_exists->School_logo;
        	$email=$this->session->userdata('Email');
        	//Escaping html entities in message.
        	$new_password=html_escape($this->input->post('new_password'));

        	//processing request
			$email_exists=$this->Organizer_model->email_real($email);
			if ($email_exists->num_rows()>0) 
			{
				$sess=sha1(time());
				$data_update = array('Password'=>password_hash($new_password, PASSWORD_BCRYPT));
				$update=$this->Teacher_model->update_teacher($data_update,$email_exists->row()->Teacher_id);
				if ($update==TRUE) 
				{
					$this->session->unset_userdata('Email');//removing the session to avoid unauthorized access.
					$this->session->set_flashdata('message_success', "You have successfully changed your login details.");
					
					    //for login notification
					    $body2 = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
					    $body2 .= "<table style='width: 100%;'>";
					    $body2 .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
					    $body2 .= "<a href='{$url_base}'><img src='{$image}' alt=''></a><br><br>";
					    $body2 .= "</td></tr></thead><tbody><tr>";
					    $body2.="Your account login details has been changed. If you did not make this change, do not hesistate to contact us for help in retrieveing your account.<br><br>";
					    $body2 .= "</tr>";
					    $body2 .= "</tbody></table>";
					    $body2 .= "</body></html>";
								//sending email
						$send=$this->email->from($webmail, $site_title)->to($email_exists->row()->Email)->subject('Password Change')->message($body2)->set_mailtype('html')->send();
					
        			redirect($url);
				}
				else
				{
					$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
        			redirect('teachers/login/resetpassword');
				}
			}
			else
			{
				$this->session->set_flashdata('message_error', "This Email does not exist");
        		redirect('teachers/login/forgotpassword');
			}
        }
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->School_name;
		$data['Page_name']='Reset Password';
		$this->load->view($page,$data);
	}
}