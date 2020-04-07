<?php 

class Pricing extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "< You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/pricing')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['packages']=$this->Organizer_model->get_packages();
		$data['Page_name']='Pricing';
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/footer.php',$data);
	}
	public function Subscribe()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Package', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data
        	$package=strip_tags(html_escape($this->input->post('id')));
        	$package_exists=$this->Organizer_model->get_package_id($package);
        	if ($package_exists->num_rows()>0) 
        	{
				//checking packages and already added school{preventing downgrade when more schools has been added}

				$college=$this->db->select('*')->from('Schools')->where('OrganizerId',$organizerid)->get();
				$number_of_schools_allowed=$package_exists->row()->Number_of_schools;
				$number_of_college=$college->num_rows();
				if ($number_of_college > $number_of_schools_allowed) 
				{
					$this->session->set_flashdata('message_error', "You cannot downgrade your plan. If you need to use a lower plan,delete some schools, and try again");
		            redirect($page);
				}
				else
				{
	        		$add=$this->db->set('Active_package',$package)->where('OrganizerId',$organizer->OrganizerId)->update('Organizer');
	        		if ($add==TRUE) 
	        		{
	        			$this->session->set_flashdata('message_success', "Your Subscription was successful and will be charged upon pin generation.");
		            	redirect($page);
	        		}
	        		else
	        		{
	        			$this->session->set_flashdata('message_error', "Subscription failed. Try again or contact support");
		            	redirect($page);
	        		}
	        	}
        	}
        	else
        	{
	        	$this->session->set_flashdata('message_error', "This Package does not exist.");
	            redirect($page);
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