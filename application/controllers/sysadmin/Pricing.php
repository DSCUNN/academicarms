<?php
/**
 * 
 */
class Pricing extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('AdminSess'))
		{
            redirect(base_url().'sysadmin/login');
		}
	}
	public function index($page='sysadmin/pricing')
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
		$data['Page_name']='Pricing';
		$data['admin']=$admin;
		$data['pricing']=$this->Admin_model->get_pricing_plans();
		$this->load->view('sysadmin/templates/header',$data);
		$this->load->view('sysadmin/templates/sidemenu',$data);
		$this->load->view('sysadmin/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('sysadmin/templates/footer',$data);
	}
	public function set_status($id=null,$status=null)
	{
		$page=$_SERVER['HTTP_REFERER'];
		$id=$this->security->xss_clean($this->uri->segment(4));
		$status=$this->security->xss_clean($this->uri->segment(5));
		$id_exists=$this->Admin_model->get_pricing_plan_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Package does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$data_array = array('Status' =>$status);
			$update=$this->Admin_model->update_pricing_plan($data_array,$id);
			if ($update==true) 
			{
				$this->session->set_flashdata('message_success','Pricing Plan successfully updated');
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
		$id=$this->security->xss_clean($this->uri->segment(4));
		$id_exists=$this->Admin_model->get_pricing_plan_id($id);
		if ($id_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error','This Package does not exist or record not found in database');
            redirect($page);
		}
		else
		{
			$delete=$this->db->where('Package_id',$id)->delete('pricing_table');
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
	public function create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('old_price', 'Old Price', 'trim|required|numeric');
        $this->form_validation->set_rules('new_price', 'New Price', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('features', 'Features', 'trim|required');
        $this->form_validation->set_rules('number_of_school', 'Number of Schools', 'trim|required|numeric');
        $this->form_validation->set_rules('is_free', 'Is Free', 'trim|required|numeric');
        $this->form_validation->set_rules('is_recommended', 'Is Recommended', 'trim|required|numeric');
        $this->form_validation->set_rules('recommend_text', 'Recommendation Text', 'trim');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$old_price=html_escape($this->input->post('old_price'));
        	$new_price=html_escape($this->input->post('new_price'));
        	$description=html_escape($this->input->post('description'));
        	$features=$this->security->xss_clean($this->input->post('features'));
        	$number_of_school=html_escape($this->input->post('number_of_school'));
        	$is_free=html_escape($this->input->post('is_free'));
        	$is_recommended=html_escape($this->input->post('is_recommended'));
        	$recommend_text=html_escape($this->input->post('recommend_text'));
        	$amount=$new_price.'/pin';
        	$exists=$this->db->from('pricing_table')->where('PackageName',$name)->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','Pricing Plan already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('PackageName' =>$name,'Description'=>$description,'Is_free'=>$is_free,'Recommended'=>$is_recommended,'Old_price'=>$old_price,'New_price'=>$new_price,'Number_of_schools'=>$number_of_school,'Recommend_text'=>$recommend_text,'Status'=>1,'Features'=>$features,'Amount'=>$amount);
				$update=$this->Admin_model->create_pricing_plan($data_array);
				if ($update==true) 
				{
					$this->session->set_flashdata('message_success','Pricing Plan Successfully Added');
	            	redirect($page);
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
	public function edit()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('old_price', 'Old Price', 'trim|required|numeric');
        $this->form_validation->set_rules('new_price', 'New Price', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');
        $this->form_validation->set_rules('features', 'Features', 'trim|required');
        $this->form_validation->set_rules('number_of_school', 'Number of Schools', 'trim|required|numeric');
        $this->form_validation->set_rules('is_free', 'Is Free', 'trim|required|numeric');
        $this->form_validation->set_rules('is_recommended', 'Is Recommended', 'trim|required|numeric');
        $this->form_validation->set_rules('recommend_text', 'Recommendation Text', 'trim');
        $this->form_validation->set_rules('id', 'Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$name=html_escape($this->input->post('name'));
        	$old_price=html_escape($this->input->post('old_price'));
        	$new_price=html_escape($this->input->post('new_price'));
        	$description=html_escape($this->input->post('description'));
        	$features=$this->security->xss_clean($this->input->post('features'));
        	$number_of_school=html_escape($this->input->post('number_of_school'));
        	$is_free=html_escape($this->input->post('is_free'));
        	$is_recommended=html_escape($this->input->post('is_recommended'));
        	$recommend_text=html_escape($this->input->post('recommend_text'));
        	$id=html_escape($this->input->post('id'));
        	$amount=$new_price.'/pin';
        	$exists=$this->db->from('pricing_table')->where('PackageName',$name)->where('Package_id!=',$id)->get();
        	if ($exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error','Pricing Plan already exists.');
	            redirect($page);
        	}
        	else
        	{
        		$data_array = array('PackageName' =>$name,'Description'=>$description,'Is_free'=>$is_free,'Recommended'=>$is_recommended,'Old_price'=>$old_price,'New_price'=>$new_price,'Number_of_schools'=>$number_of_school,'Recommend_text'=>$recommend_text,'Status'=>1,'Features'=>$features,'Amount'=>$amount);
				$update=$this->Admin_model->update_pricing_plan($data_array,$id);
				if ($update==true) 
				{
					$this->session->set_flashdata('message_success','Pricing Plan Successfully Updated');
	            	redirect($page);
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
	public function get_pricing_plan_id($id)
	{
		$results=$this->Admin_model->get_pricing_plan_id($id);
		$results=$results->result();
		echo json_encode($results);
	}
}