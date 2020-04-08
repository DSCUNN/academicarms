<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index($page='home')
	{
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$general_settings->row()->Site_name;
		$data['Page_name']='Home';
		$this->load->view('templates/header',$data);
		$this->load->view('templates/menu',$data);
		$this->load->view($page,$data);
		$this->load->view('templates/footer',$data);
	}
	public function Contact()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	//Escaping html entities in message.
        	$name=html_escape($this->input->post('name'));
        	$email=html_escape($this->input->post('email'));
        	$subject=html_escape($this->input->post('subject'));
        	$message=html_escape($this->input->post('message'));
        	$site_title=$general_settings->row()->Site_name;
		    $webmail=$general_settings->row()->Site_email;
			$logo =$general_settings->row()->Site_logo;
			$link = base_url().'assets/dashboard/logo/';
			$links=base_url();
			$linkss=base_url();
			$image=$link.$logo;
			$body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
			$body .= "<table style='width: 100%;'>";
			$body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";
			$body .= "<a href='{$links}'><img src='{$image}' alt=''></a><br><br>";
			$body .= "</td></tr></thead><tbody><tr>";
			$body.=" Name: $name<br> Email: $email<br> Subject: $subject<br> Message: $message ";
			$body .= "</tr>";
			$body .= "</tbody></table>";
			$body .= "</body></html>";
			//sending email
		    $send=$this->email->from($webmail, $site_title)->to($webmail)->subject('New Contact Message')->message($body)->set_mailtype('html')->send();
	        if ($send==TRUE) 
	        {
	        	$this->session->set_flashdata('message_success', "Your message has been successfully Sent. We will attend to it as soon as possible. Meanwhile, checkout the FAQ section from your dashboard, or open a support ticket if you need a fater help.");
	        	redirect($page);
	        }
	        else
	        {
	        	$this->session->set_flashdata('message_error', "We are currently unable to handle your request.");
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
}
