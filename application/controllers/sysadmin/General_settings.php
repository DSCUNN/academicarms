<?php
/**
 * 
 */
class General_settings extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/general_settings')
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
		$data['Page_name']='General settings';
		$data['admin']=$admin;
		$this->load->view('sysadmin/templates/header',$data);
		$this->load->view('sysadmin/templates/sidemenu',$data);
		$this->load->view('sysadmin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer',$data);
	}
	public function Basic()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('site_name', 'Site Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('site_email', 'Site Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('site_supportemail', 'Site Support Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('site_description', 'Site Description', 'trim|required');
        $this->form_validation->set_rules('site_tag', 'Site Tag', 'trim|required');
        $this->form_validation->set_rules('site_phone', 'Site Phone', 'trim|required');
        $this->form_validation->set_rules('site_shortname', 'Site Shortname', 'trim|required|alpha');
        $this->form_validation->set_rules('footer_about', 'Footer About', 'trim|required');
        $this->form_validation->set_rules('footer_text', 'Footer Text', 'trim|required');
        $this->form_validation->set_rules('site_address', 'Site Address', 'trim|required');
        $this->form_validation->set_rules('site_country', 'Site Country', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('site_state', 'Site State', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('currency', 'Site Currency', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('currency_sign', 'Currency Sign', 'trim|required');
        $this->form_validation->set_rules('site_maintenance', 'Maintenance', 'trim|required|numeric');
        $this->form_validation->set_rules('site_notification', 'Site Notification', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$site_name=$this->security->xss_clean($this->input->post('site_name'));
        	$site_email=$this->security->xss_clean($this->input->post('site_email'));
        	$site_supportemail=$this->security->xss_clean($this->input->post('site_supportemail'));
        	$site_description=$this->security->xss_clean($this->input->post('site_description'));
        	$site_tag=$this->security->xss_clean($this->input->post('site_tag'));
        	$site_phone=$this->security->xss_clean($this->input->post('site_phone'));
        	$site_shortname=$this->security->xss_clean($this->input->post('site_shortname'));
        	$footer_text=$this->security->xss_clean($this->input->post('footer_text'));
        	$footer_about=$this->security->xss_clean($this->input->post('footer_about'));
        	$site_address=$this->security->xss_clean($this->input->post('site_address'));
        	$site_country=$this->security->xss_clean($this->input->post('site_country'));
        	$site_state=$this->security->xss_clean($this->input->post('site_state'));
        	$currency=$this->security->xss_clean($this->input->post('currency'));
        	$currency_sign=$this->security->xss_clean($this->input->post('currency_sign'));
        	$site_maintenance=$this->security->xss_clean($this->input->post('site_maintenance'));
        	$site_notification=$this->security->xss_clean($this->input->post('site_notification'));

        	$data_array = array('Site_name' =>$site_name,'Site_email'=>$site_email,'Site_tag'=>$site_tag,'Site_description'=>$site_description,'Site_shortname'=>$site_shortname,'Site_phone'=>$site_phone,'footer_text'=>$footer_text,'Footer_about'=>$footer_about,'Site_address'=>$site_address,'Site_state'=>$site_state,'Site_country'=>$site_country,'Site_supportemail'=>$site_supportemail,'Site_notification'=>$site_notification,'Maintenance'=>$site_maintenance,'Currency'=>$currency,'Currency_sign'=>$currency_sign);
				
			$update=$this->Admin_model->update_settings($data_array);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Settings Successfully updated');
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
	public function Security_others()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('twoway', 'Site Two Way Authentication', 'trim|required|numeric');
        $this->form_validation->set_rules('email_verification', 'Email Verification', 'trim|required|numeric');
        $this->form_validation->set_rules('registration', 'Site Registration', 'trim|required|numeric');
        $this->form_validation->set_rules('newsletter', 'Site Newsletter', 'trim|required|numeric');
        $this->form_validation->set_rules('mastercode', 'Master code length', 'trim|required|numeric');
        $this->form_validation->set_rules('securitycode', 'Security Code length', 'trim|required|numeric');
        $this->form_validation->set_rules('resultpin', 'Result Pin Length', 'trim|required|numeric');
        $this->form_validation->set_rules('serialpin', 'Serial Pin Length', 'trim|required|numeric');
        $this->form_validation->set_rules('pin_usage', 'Pin Usage', 'trim|required|numeric');
        $this->form_validation->set_rules('result_type', 'Default Result System', 'trim|required|numeric');
        $this->form_validation->set_rules('addstudents', 'Teachers can add Students', 'trim|required|numeric');
        $this->form_validation->set_rules('addresults', 'Teachers can add results', 'trim|required|numeric');
        $this->form_validation->set_rules('testmonials', 'Show Testmonial', 'trim|required|numeric');
        $this->form_validation->set_rules('newsletter_link', 'Newsletter Link', 'trim');
		if ($this->form_validation->run() == TRUE)
        {
        	$twoway=$this->security->xss_clean($this->input->post('twoway'));
        	$email_verification=$this->security->xss_clean($this->input->post('email_verification'));
        	$registration=$this->security->xss_clean($this->input->post('registration'));
        	$newsletter=$this->security->xss_clean($this->input->post('newsletter'));
        	$mastercode=$this->security->xss_clean($this->input->post('mastercode'));
        	$securitycode=$this->security->xss_clean($this->input->post('securitycode'));
        	$resultpin=$this->security->xss_clean($this->input->post('resultpin'));
        	$serialpin=$this->security->xss_clean($this->input->post('serialpin'));
        	$pin_usage=$this->security->xss_clean($this->input->post('pin_usage'));
        	$result_type=$this->security->xss_clean($this->input->post('result_type'));
        	$addstudents=$this->security->xss_clean($this->input->post('addstudents'));
        	$addresults=$this->security->xss_clean($this->input->post('addresults'));
        	$testmonials=$this->security->xss_clean($this->input->post('testmonials'));
        	$newsletter_link=$this->security->xss_clean($this->input->post('newsletter_link'));

        	$data_array = array('Resultpin_length'=>$resultpin,'Pin_usage'=>$pin_usage,'Teacher_add_students'=>$addstudents,'Teacher_add_result'=>$addresults,'Serialpin_length'=>$serialpin,'Result_type'=>$result_type,'Site_twoway'=>$twoway,'Link'=>$newsletter_link,'show_testmonials'=>$testmonials,'Allow_newsletter'=>$newsletter,'Site_registration'=>$registration,'Mastercode_length'=>$mastercode,'Securitycode_length'=>$securitycode,'Email_verification'=>$email_verification);
				
			$update=$this->Admin_model->update_settings($data_array);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Settings Successfully updated');
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
	public function logo()
	{
		$redirect_page=$_SERVER['HTTP_REFERER'];
		//Configuring Image Path
	        $config['upload_path']          = './assets/dashboard/logo/';
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

					$data_array = array('Site_logo'=>$image_name);
					$add=$this->Admin_model->update_settings($data_array);
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
}