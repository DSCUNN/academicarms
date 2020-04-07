<?php 

class Faq extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/faq')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['Page_name']='Frequently Asked Questions';
		$data['categories']=$this->Organizer_model->get_categories();
		$data['faq']=$this->Organizer_model->get_faq();
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/footer.php',$data);
	}
	public function new_faq()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('category', 'Category', 'trim|required|numeric');
		$this->form_validation->set_rules('question', 'Question', 'trim|required');
		$this->form_validation->set_rules('answer', 'Answer', 'trim');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data
        	$category=strip_tags(html_escape($this->input->post('category')));
        	$answer=strip_tags(html_escape($this->input->post('answer')));
        	$question=strip_tags(html_escape($this->input->post('question')));
        	$category_exists=$this->Organizer_model->get_category_id($category);
        	if ($category_exists->num_rows()>0) 
        	{
        		$data=array('Category'=>$category,'Question'=>$question,'Answer'=>$answer);
	        	$add=$this->db->insert('Faq_request',$data);
	        	if ($add==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Your Suggested FAQ has been successfully submitted and will be looked into. Thanks for the heads up.");
		            redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Submisssion failed. Try again or contact support");
		            redirect($page);
	        	}
        	}
        	else
        	{
	        	$this->session->set_flashdata('message_error', "This Category does not exist.");
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