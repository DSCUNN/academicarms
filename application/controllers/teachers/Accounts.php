<?php 

class Accounts extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('TeacherSess'))
		{
            redirect(base_url().'index');
		}
	}
	public function index($page='teachers/account')
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('TeacherSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		//retrieving data from stored sessions
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		if ($school_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','You have no access to this page');
			redirect($redirect_page);
		}
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['Page_name']='Account Settings';
		$data['school_exists']=$school_exists->row();
		$data['teacher']=$teacher->row();
		$this->load->view('teachers/templates/header.php',$data);
		$this->load->view('teachers/templates/sidemenu.php',$data);
		$this->load->view('teachers/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('teachers/templates/footer.php',$data);
	}
	public function Profile_image()
	{
		
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('TeacherSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		//retrieving data from stored sessions
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		if ($school_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','You have no access to this page');
			redirect($redirect_page);
		}
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		//Configuring Image Path
	        $config['upload_path']          = './assets/dashboard/assets/img/users/';
	        $config['allowed_types']        = 'gif|jpg|png|jpeg';
	        $config['max_size']             =  '6000';
	        $config['overwrite']            =  FALSE;
	        $config['detect_mime']          =  TRUE;
	        $config['encrypt_name']         =  TRUE;
	        $config['remove_spaces']        =  TRUE; 
	    		$this->upload->initialize($config);
		        $uploaded=$this->upload->do_upload('photo');
		        $image_name=$this->upload->data('file_name');
		        if (!$uploaded)
		        {
		            $error = $this->upload->display_errors();
		            $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
		                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
		                                        <span>$error</span>
		                        </div>");
		            redirect($redirect_page);
		        }
		        else
		        {

					$data_array = array('Photo'=>$image_name);
					$add=$this->Teacher_model->update_teacher($data_array,$teacher_id);
					if ($add==true) 
					{
						$this->session->set_flashdata('message_success', "Successfully  updated.");
	           		 	redirect($redirect_page);
					}
					else
					{
						$this->session->set_flashdata('message_error', "Something went wrong");
	            		redirect($redirect_page);
					}
					
		        }
	}
	public function login()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$redirect_page=$_SERVER['HTTP_REFERER'];
		if (!$this->session->userdata('TeacherSess'))
		{
			$this->session->set_flashdata('message_error','You have no access to this page.');
            redirect($redirect_page);
		}
		//retrieving data from stored sessions
		$school=$this->session->userdata('School_teacher');
		$organizerid=$this->session->userdata('School_organ');
		$school_exists=$this->Organizer_model->get_school_id($school,$organizerid);
		if ($school_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','You have no access to this page');
			redirect($redirect_page);
		}
		$teacher_sess=$this->session->userdata('TeacherSess');
		$teacher_id=$this->session->userdata('Teacherid');
		$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules		
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
		if ($this->form_validation->run() == TRUE)
        {
			$teacher_sess=$this->session->userdata('TeacherSess');
			$teacher_id=$this->session->userdata('Teacherid');
			$teacher=$this->Teacher_model->Teacher_details($teacher_id,$teacher_sess);
			//processing submitted data
        	$new_password=strip_tags(html_escape($this->input->post('new_password')));
        	$old_password=strip_tags(html_escape($this->input->post('old_password')));

        	$hashed=password_verify($old_password, $teacher->row()->Password);
        	
        	//checking if old password is correctly
        	if ($hashed!=TRUE) 
        	{
        		$this->session->set_flashdata('message_error', "Old Password is wrong.");
		            redirect($page);
        	}
        	else 
        	{
        		
					$data=array('Password'=>password_hash($new_password, PASSWORD_BCRYPT));
					$update=$this->Teacher_model->update_teacher($data,$teacher_id);
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