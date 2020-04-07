<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkresult extends CI_Controller {

	public function index($page='schools/checkresult')
	{
		//retrieve the requested url and sanitizing against invisible characters 
		$school= remove_invisible_characters(strtolower($this->uri->segment(2)));
		//check if school exists.
		$school_exists=$this->db->select('*')->from('Schools')->where('School_url',$school)->get();
		if ($school_exists->num_rows()>0) 
		{
			$school_status=$school_exists->row()->School_status;
			if ($school_status!=1) 
			{
				$this->session->set_flashdata('message_error','We cannot display the requested school at the moment. Contact your school System administrator for more information');
				redirect('index');
			}
			else
			{
				$general_settings=$this->Web_model->general_settings();
				$classes=$this->db->select('*')->from('Classes')->where('Status',1)->where('OrganizerId',$school_exists->row()->OrganizerId)->where('School',$school_exists->row()->School_id)->get();
				$sessions=$this->db->select('*')->from('Session')->where('Status',1)->where('OrganizerId',$school_exists->row()->OrganizerId)->where('School_id',$school_exists->row()->School_id)->get();
				$terms=$this->db->select('*')->from('Semester')->where('Status',1)->where('OrganizerId',$school_exists->row()->OrganizerId)->where('School_id',$school_exists->row()->School_id)->get();
				$result_type=$this->db->select('*')->from('Result_type')->where('Status',1)->where('OrganizerId',$school_exists->row()->OrganizerId)->where('School_id',$school_exists->row()->School_id)->get();
				$data['general_settings']=$general_settings;
				$data['pagename']='Result Checking Page';
				$data['sessions']=$sessions;
				$data['semesters']=$terms;
				$data['classes']=$classes;
				$data['result_types']=$result_type;
				$data['general_settings']=$general_settings;
				$data['school']=$school_exists->row();
				$data['Site_name']=$school_exists->row()->School_name;
				$data['url_slug']=$school_exists->row()->School_url;
				$this->load->view($page,$data);
			}
		}
		else
		{
			$this->session->set_flashdata('message_error','The requested school does not exist. This could be as a result of misspelling or network glitch.');
			redirect('index');
		}
	}
	public function Authenticate()
	{
		$page=$_SERVER['HTTP_REFERER'];
		//retrieve the requested url and sanitizing against invisible characters 
		$school= remove_invisible_characters(strtolower($this->uri->segment(2)));
		//check if school exists.
		$school_exists=$this->db->select('*')->from('Schools')->where('School_url',$school)->get();
		if ($school_exists->num_rows()>0) 
		{
			$school_status=$school_exists->row()->School_status;
			if ($school_status!=1) 
			{
				$this->session->set_flashdata('message_error','We cannot display the requested school at the moment. Contact your school System administrator for more information');
				redirect('index');
			}
			else
			{
				$general_settings=$this->Web_model->general_settings();
				//Set Form Validation Rules
				$this->form_validation->set_rules('pin', 'Pin Number', 'trim|required|alpha_numeric');
		        $this->form_validation->set_rules('serial', 'Serial Code', 'trim|required|alpha_numeric');
		        $this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		        $this->form_validation->set_rules('session', 'Academic Session', 'trim|required|numeric');
		        $this->form_validation->set_rules('semester', 'Semester/Term', 'trim|required|numeric');
		        $this->form_validation->set_rules('username', 'Username', 'trim|required');
		        $this->form_validation->set_rules('result_typ', 'Result Type', 'trim|numeric');
				if ($this->form_validation->run() == TRUE)
		        {
		        	$pin_usage=$school_exists->row()->Pin_usage;
		        	$serial=html_escape($this->input->post('serial'));
		        	$pin=html_escape($this->input->post('pin'));
		        	$class=html_escape($this->input->post('class'));
		        	$session=html_escape($this->input->post('session'));
		        	$semester=html_escape($this->input->post('semester'));
		        	$username=html_escape($this->input->post('username'));
		        	$result_typ=html_escape($this->input->post('result_typ'));
		        	$pin_exists=$this->Web_model->pin_exist($pin,$school_exists->row()->School_id,$school_exists->row()->OrganizerId);//check if pin exists
		        	if ($pin_exists->num_rows() >0) 
		        	{
		        		$pin_serial_exists=$this->Web_model->serial_pin_exist($pin,$serial,$school_exists->row()->School_id,$school_exists->row()->OrganizerId);
		        		if ($pin_serial_exists->num_rows() >0) 
		        		{
		        			$pin_id=$pin_serial_exists->row()->Pin_id;
		        			$pin_in_use=$this->Web_model->Pin_use($pin_id);
		        			//check if pin has been used above the system usage
		        			if ($pin_in_use->num_rows()==$pin_usage) 
		        			{
		        				$this->session->set_flashdata('message_error', "You have exceeded the maximum number of times this pin can be used");
				        		redirect($page);
		        			}
		        			else
		        			{   
		        				$student_exist=$this->Web_model->Student($username,$school_exists->row()->School_id,$school_exists->row()->OrganizerId);//checking if student exists
		        				//checking if student details is true
		        				if ($student_exist->num_rows()>0) 
		        				{
		        					$student_id=$student_exist->row()->Student_id;
		        					//Limiting the usage to a single user for a class,an academic session, and a semester/term
		        					if ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Student !=$student_id) 
		        					{
		        						$this->session->set_flashdata('message_error', "Pin has been used by another student.");
				        				redirect($page);        					
				        			}
				        			elseif ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Class !=$class) 
				        			{
				        				$this->session->set_flashdata('message_error', "Pin has been used for another Class.");
				        				redirect($page); 
				        			}
				        			elseif ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Session !=$session) 
				        			{
				        				$this->session->set_flashdata('message_error', "Pin has been used for another Academic Session.");
				        				redirect($page); 
				        			}
				        			elseif ($pin_in_use->num_rows()>0 && $pin_in_use->row()->Term !=$semester) 
				        			{
				        				$this->session->set_flashdata('message_error', "Pin has been used for another Semester/Term.");
				        				redirect($page); 
				        			}
				        			else
				        			{
				        				//When all authentication has reulted to true
				        				$result_published=$this->Web_model->result_published($student_id,$class,$semester,$session,$school_exists->row()->School_id,$school_exists->row()->OrganizerId);
				        				//check if result has been published
				        				if ($result_published->num_rows() >0) 
				        				{
				        					$result_session_data = array('Class'=>$class,'Student'=>$student_id,'Aca_Session'=>$session,'Semester'=>$semester,'Set'=>TRUE,'Result_typ'=>$result_typ,'School'=>$school_exists->row()->School_id,'Organizer'=>$school_exists->row()->OrganizerId,'Pin_uses'=>$pin_in_use->num_rows());
				        					$result_session=$this->session->set_userdata($result_session_data);
				        					if ($this->session->has_userdata('Set')) 
				        					{
				        						$update_pin_data  = array('Pin_id' =>$pin_id,'Student'=>$student_id,'Class'=>$class,'Term'=>$semester,'Session'=>$session,'School_id'=>$school_exists->row()->School_id);
				        						$update_pin_usage=$this->Web_model->update_pin_usage($update_pin_data);//insert pin usage record
				        						if ($update_pin_usage==TRUE) 
				        						{
				        							//get pin usage number of rows after each insertion and updating pin status
				        							$pin_usage_now=$this->db->select('*')->from('Pin_usage')->where('Pin_id',$pin_id)->get();
				        							if ($pin_usage_now->num_rows()< $pin_usage) 
				        							{
				        								$pin_status=2;
				        							}
				        							else
				        							{
				        								$pin_status=3;
				        							}
				        							//update pin status
				        							$pin_stat_update=$this->db->set('Status',$pin_status)->where('Pin_id',$pin_id)->update('Result_pins');
				        							//take to result viewing page
				        							if ($pin_stat_update==TRUE) 
				        							{
				        								redirect('schools/checkresult/result_page');
				        							}
				        						}

				        					}
				        				}
				        				else
				        				{
				        					$this->session->set_flashdata('message_error', "Your Result has not been published. Check Back in few days or Contact your School Administrator.");
				        					redirect($page);
				        				}
				        			}
		        				}
		        				else
		        				{
		        					$this->session->set_flashdata('message_error', "Username is Invalid.");
				        			redirect($page);
		        				}
		        			}
		        		}
		        		else
			        	{
				        	$this->session->set_flashdata('message_error', "Combination of Pin and Serial Number is invalid.");
				        	redirect($page);
			        	}
		        	}
		        	else
		        	{
			        	$this->session->set_flashdata('message_error', "The Result Pin entered is invalid.");
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
		else
		{
			$this->session->set_flashdata('message_error','The requested school does not exist. This could be as a result of misspelling or network glitch.');
			redirect($page);
		}
	}
	public function result_page($page='schools/check_result')
	{
		$pages=$_SERVER['HTTP_REFERER'];
		if (!$this->session->has_userdata('Set')) 
		{
			$this->session->set_flashdata('message_error', "Please use a valid pin and serial number to check result");
		    redirect($pages); 
		}

		$general_settings=$this->Web_model->general_settings();
		$class=$this->session->userdata('Class');
		$organizer=$this->session->userdata('Organizer');
		$school=$this->session->userdata('School');
		$result_typ=$this->session->userdata('Result_typ');
		$session=$this->session->userdata('Aca_Session');
		$semester=$this->session->userdata('Semester');
		$student=$this->session->userdata('Student');
		$result=$this->Web_model->results_published($student,$class,$semester,$session,$school,$organizer);
		$position=$this->Web_model->position_published($student,$class,$semester,$session,$result_typ,$school,$organizer);
		$school_exists=$this->db->select('*')->from('Schools')->where('School_id',$school)->where('OrganizerId',$organizer)->get();
		$data['general_settings']=$general_settings;
		$data['Site_name']=$school_exists->row()->School_name;
		$data['Page_name']='Result Page';
		$data['sresults']=$result;
		$data['position']=$position;
		$data['num_students']=$this->db->select('*')->from('Student')->where('Class',$class)->where('School_id',$school)->where('OrganizerId',$organizer)->get();
		$data['pin_use']=$this->session->userdata('Pin_uses');
		$data['school']=$school_exists->row();
		$data['class']=$this->db->select('*')->from('Classes')->where('Class_id',$class)->where('School',$school)->where('OrganizerId',$organizer)->get();
		$data['session']=$this->db->select('*')->from('Session')->where('Session_id',$session)->where('School_id',$school)->where('OrganizerId',$organizer)->get();
		$data['semester']=$this->db->select('*')->from('Semester')->where('Semester_id',$semester)->where('School_id',$school)->where('OrganizerId',$organizer)->get();
		$data['teacher']=$this->db->select('*')->from('Teacher')->where('Class',$class)->where('School_id',$school)->where('OrganizerId',$organizer)->get();
		$data['student']=$this->db->select('*')->from('Student')->where('Student_id',$student)->where('Class',$class)->where('School_id',$school)->where('OrganizerId',$organizer)->get();
		$this->load->view('account/templates/result_header',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/print_result_footer',$data);
	}
}
