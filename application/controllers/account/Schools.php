<?php 

class Schools extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/schools')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['school_types']=$this->Organizer_model->get_school_type($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Schools';
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/school_footer.php',$data);
	}
	public function New_school()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'School', 'trim|required');
		$this->form_validation->set_rules('description', 'School Description', 'trim|required');
		$this->form_validation->set_rules('url', 'School Url', 'trim');
		$this->form_validation->set_rules('status', 'School Status', 'trim|required|numeric');
		$this->form_validation->set_rules('type', 'School Type', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	//Configuring Image Path
	        $paths='./assets/dashboard/logo/schools';
	        $config['upload_path']          = $paths;
	        $config['allowed_types']        = 'gif|jpg|png';
	        $config['max_size']             = '10000';
	        $config['encrypt_name']         = TRUE;

			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			$package=$this->Organizer_model->get_package_id($organizer->Active_package);
			$college=$this->db->select('*')->from('Schools')->where('OrganizerId',$organizerid)->get();
			$number_of_schools_allowed=$package->row()->Number_of_schools;
			$number_of_college=$college->num_rows();
			//processing submitted data and sanitizing them
        	$name=strip_tags(html_escape($this->input->post('name')));
        	$description=strip_tags(html_escape($this->input->post('description')));
        	$url1=strip_tags(html_escape($this->input->post('url')));
        	$status=strip_tags(html_escape($this->input->post('status')));
        	$type=strip_tags(html_escape($this->input->post('type')));
        	if (empty($url1)) 
        	{
        		$url=str_replace(' ', '-', $name);
        	}
        	else
        	{
        		$url=str_replace(' ', '-', $url1);
        	}
        	//checking if submitted data already exists
        	$school_exists=$this->db->select('*')->from('Schools')->where('School_name',$name)->get();
        	$url_exists=$this->db->select('*')->from('Schools')->where('School_url',$url)->get();
        	if ($number_of_college==$number_of_schools_allowed) 
        	{
        		$this->session->set_flashdata('message_error', "You have gotten to the maximum number of schools permitted on your package. Upgrade to a higher plan to add more schools");
	            redirect($page);
        	}
        	elseif ($school_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "School Name already Exists.");
	            redirect($page);
        	}
        	elseif ($url_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Please use a unique text for your url");
	            redirect($page);
        	}
        	else 
        	{
        		$this->upload->initialize($config);
                $uploads=$this->upload->do_upload('logo');
                $imagename=$this->upload->data('file_name');

                if (!$uploads) 
                {
                    $error=$this->upload->display_errors();
                    $this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\">
                                        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                                        <span>$error</span>
                                    </div>");
                    redirect($page);
                }

        		$schoolmark=$general_settings->row()->Site_shortname."-".rand(100000,99999999999);
        		$data = array('School_name' =>$name,'School_description'=>$description,'School_mark'=>$schoolmark,'School_status'=>$status,'School_type'=>$type,'OrganizerId'=>$organizerid,'School_url'=>$url,'Date_created'=>time(),'School_logo'=>$imagename,'Resultpin_length'=>$general_settings->row()->Resultpin_length,'Serialpin_length'=>$general_settings->row()->Serialpin_length,'Pin_usage'=>$general_settings->row()->Pin_usage,'Result_type'=>$general_settings->row()->Result_type);
        		$add=$this->Organizer_model->create_school($data);
        		if ($add==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "School Successfully Created.");
	            	redirect($page);
        		}
        		else
	        	{
		        	$this->session->set_flashdata('message_error', "Process Failed");
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
	public function update_school()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name', 'School', 'trim|required');
		$this->form_validation->set_rules('id', 'School Id', 'trim|required|numeric');
		$this->form_validation->set_rules('description', 'School Description', 'trim|required');
		$this->form_validation->set_rules('url', 'School Url', 'trim|required');
		$this->form_validation->set_rules('status', 'School Status', 'trim|required|numeric');
		$this->form_validation->set_rules('type', 'School Type', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data and sanitizing them
        	$name=strip_tags(html_escape($this->input->post('name')));
        	$id=strip_tags(html_escape($this->input->post('id')));
        	$description=strip_tags(html_escape($this->input->post('description')));
        	$url=strtolower(strip_tags(html_escape($this->input->post('url'))));
        	$status=strip_tags(html_escape($this->input->post('status')));
        	$type=strip_tags(html_escape($this->input->post('type')));
        	//checking if submitted data already exists
        	$school_exists=$this->db->select('*')->from('Schools')->where('School_name',$name)->where('School_id!=',$id)->get();
        	$url_exists=$this->db->select('*')->from('Schools')->where('School_url',$url)->where('School_id!=',$id)->get();
        	if ($school_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "School Name already Exists.");
	            redirect($page);
        	}
        	elseif ($url_exists->num_rows()>0) 
        	{
        		$this->session->set_flashdata('message_error', "Please use a unique text for your url");
	            redirect($page);
        	}
        	else 
        	{
        		$data = array('School_name' =>$name,'School_description'=>$description,'School_status'=>$status,'School_type'=>$type,'School_url'=>$url);
        		$update=$this->Organizer_model->update_school($data,$id,$organizerid);
        		if ($update==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "School Successfully Created.");
	            	redirect($page);
        		}
        		else
	        	{
		        	$this->session->set_flashdata('message_error', "Process Failed");
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
	public function delete_school()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'School Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$school_exists=$this->db->select('*')->from('Schools')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
        	if ($school_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "School does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('School_id',$id)->where('OrganizerId',$organizerid)->delete('Schools');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "School was Successfully Deleted");
		        	redirect($page);
        		}
        		else
        		{
        			$this->session->set_flashdata('message_error', "Process Failed");
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
	public function delete_school_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Schools');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "School Types Successfully Deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
	public function get_school_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$school_type=$this->Organizer_model->get_school_id($id,$organizerid);
		$result=$school_type->result();
		echo json_encode($result);
	}
	public function School_settings($id=null)
	{
		$pages=$_SERVER['HTTP_REFERER'];
		$page='account/school_settings';
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$id=html_escape($id);
		//school exists
		$school_exists=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
		if ($school_exists->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "Requested School does not exist or you have no clearance to view this page.");
		    redirect($pages);
		}

		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['school']=$school_exists->row();
		$data['Page_name']='Settings';
		$this->load->view('account/templates/header.php',$data);
		$this->load->view('account/templates/sidemenu.php',$data);
		$this->load->view('account/templates/topmenu.php',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/school_footer',$data);
	}
	public function Settings()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('resultpin', 'Result Pin Length', 'trim|required|integer');
		$this->form_validation->set_rules('id', 'School Id', 'trim|required');
		$this->form_validation->set_rules('phone', 'School Phone', 'trim|required');
		$this->form_validation->set_rules('address', 'School Address', 'trim|required');
		$this->form_validation->set_rules('email', 'School Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('serialpin', 'Serial Code Length', 'trim|required|integer');
		$this->form_validation->set_rules('addresults', 'Teacher Add Result', 'trim|required|integer');
		$this->form_validation->set_rules('addstudents', 'Teacher Add Students', 'trim|required|integer');
		$this->form_validation->set_rules('result_type', 'Result System', 'trim|required|integer');
		$this->form_validation->set_rules('usage', 'Pin Usage', 'trim|required|integer');
		$this->form_validation->set_rules('round_to', 'CGPA Roundoff', 'trim|required|integer');
		$this->form_validation->set_rules('passcode', 'pass code', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
			$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
			//processing submitted data
        	$resultpin=strip_tags(html_escape($this->input->post('resultpin')));
        	$serialpin=strip_tags(html_escape($this->input->post('serialpin')));
        	$addresults=strip_tags(html_escape($this->input->post('addresults')));
        	$addstudents=strip_tags(html_escape($this->input->post('addstudents')));
        	$result_type=strip_tags(html_escape($this->input->post('result_type')));
        	$round_to=strip_tags(html_escape($this->input->post('round_to')));
        	$id=strip_tags(html_escape($this->input->post('id')));
        	$email=strip_tags(html_escape($this->input->post('email')));
        	$address=strip_tags(html_escape($this->input->post('address')));
        	$phone=strip_tags(html_escape($this->input->post('phone')));
        	$usage=strip_tags(html_escape($this->input->post('usage')));
        	$passcode=strip_tags(html_escape($this->input->post('passcode')));
        	$passver=password_verify($passcode, $organizer->Password);
	        $school_exists=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();
			if ($school_exists->num_rows()<1) 
			{
				$this->session->set_flashdata('message_error', "Requested School does not exist or you have no clearance to view this page.");
			    redirect($page);
			}
			else
			{
        		if ($passver!=TRUE && $passcode!=$organizer->MasterCode) 
        		{
        			$this->session->set_flashdata('message_error', "Wrong Passcode combination. Try again.");
		            redirect($page);
        		}
        		else
        		{
					$data=array('Resultpin_length'=>$resultpin,'Serialpin_length'=>$serialpin,'Pin_usage'=>$usage,'Teacher_add_students'=>$addstudents,'Teacher_add_result'=>$addresults,'Result_type'=>$result_type,'Address'=>$address,'Phone'=>$phone,'Email'=>$email,'Round_to'=>$round_to);
					$update=$this->Organizer_model->update_school($data,$school_exists->row()->School_id,$organizerid);
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
		    }    }
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