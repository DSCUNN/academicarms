<?php
defined('BASEPATH') OR exit('Access denied');

class Results extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/results')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/result_footer',$data);
	}
	public function school($id=null)
	{
		$pages='account/result_school';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$id;
		$data['school']=$schools;
		$data['classes']=$this->Organizer_model->get_classes_school($organizerid,$schools->row()->School_id);
		$data['results']=$this->Organizer_model->results_grouped($schools->row()->School_id,$organizerid);
		$data['sessions']=$this->Organizer_model->get_session_school($schools->row()->School_id,$organizerid);
		$data['terms']=$this->Organizer_model->get_semester_school($schools->row()->School_id,$organizerid);
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/result_footer',$data);	
	}
	//get class students details through ajax request
	public function get_class_students($id)
	{
		$result = $this->db->select("*")
                           ->from("Student")
                           ->where("Class",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	//get class subjects details through ajax request
	public function get_class_subject($id)
	{
		$result = $this->db->select("*")
                           ->from("Subject_combination")
                           ->join("Subject",'Subject.Subject_id=Subject_combination.Subject')
                           ->where("Class",$id)
                           ->get()->result();
       echo json_encode($result);
	}
	public function session($id=null)
	{
		$pages='account/result_session';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$results=$this->Organizer_model->results_session($session_mk,$schools->row()->School_id,$organizerid);
		$session=$this->Organizer_model->get_session_school($schools->row()->School_id,$organizerid);
		$term=$this->Organizer_model->get_semester_school($schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['results']=$results;
		$data['sessions']=$session;
		$data['terms']=$term;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/result_footer',$data);	
	}
	public function semester($id=null)
	{
		$pages='account/result_semester';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$results=$this->Organizer_model->results_semester($session_mk,$semester_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['results']=$results;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/result_footer',$data);	
	}
	public function classes($id=null)
	{
		$pages='account/result_class';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$class_mk=$this->uri->segment(7);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$results=$this->Organizer_model->results_class($session_mk,$semester_mk,$class_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['results']=$results;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/result_footer',$data);	
	}
	public function student($id=null)
	{
		$pages='account/result_student';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$class_mk=$this->uri->segment(7);
		$student_mk=$this->uri->segment(8);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$results=$this->Organizer_model->results_student($session_mk,$semester_mk,$class_mk,$student_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['results']=$results;
		$data['school_mk']=$school_mk;
		$data['session_mk']=$session_mk;
		$data['semester_mk']=$semester_mk;
		$data['class_mk']=$class_mk;
		$data['student_mk']=$student_mk;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/result_footer',$data);	
	}
	public function print_result($id=null)
	{
		$pages='account/print_result';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();


		$school_mk=$this->uri->segment(4);
		$session_mk=$this->uri->segment(5);
		$semester_mk=$this->uri->segment(6);
		$class_mk=$this->uri->segment(7);
		$student_mk=$this->uri->segment(8);
		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$school_mk)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school");
	        redirect($page);
		}
		$results=$this->Organizer_model->results_student($session_mk,$semester_mk,$class_mk,$student_mk,$schools->row()->School_id,$organizerid);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['results']=$results;
		$data['school_mk']=$school_mk;
		$data['session_mk']=$session_mk;
		$data['semester_mk']=$semester_mk;
		$data['class_mk']=$class_mk;
		$data['student_mk']=$student_mk;
		$data['Page_name']=$schools->row()->School_name.' Results';
		$this->load->view('account/templates/header',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/print_result_footer',$data);	
	}
	public function Create()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('name[]', 'Subject Id', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');;
        $this->form_validation->set_rules('school', 'School', 'trim|required');
		$this->form_validation->set_rules('class', 'Class', 'trim|required|numeric');
		$this->form_validation->set_rules('examscore[]', 'Exam Score', 'trim|required|numeric');
		$this->form_validation->set_rules('testscore[]', 'Test Score', 'trim|numeric');
		$this->form_validation->set_rules('student', 'Student', 'trim|required|numeric');
		$this->form_validation->set_rules('session', 'Session', 'trim|required');
		$this->form_validation->set_rules('term', 'Semester', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$sujectss=array();
        	$name=html_escape($this->input->post('name'));
        	$school=html_escape($this->input->post('school'));
        	$class=html_escape($this->input->post('class'));
        	$examscore=html_escape($this->input->post('examscore'));
        	$testscore=html_escape($this->input->post('testscore'));
        	$student=html_escape($this->input->post('student'));
        	$status=html_escape($this->input->post('status'));
        	$sess=html_escape($this->input->post('session'));
        	$terms=html_escape($this->input->post('term'));
        	//check if selected school belongs to organizer
        	$school_exists=$this->db->select('*')->from('Schools')->where('School_mark',$school)->where('OrganizerId',$organizerid)->get();        	
        	if ($school_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message_error', "Process Failed. You do not have clearance to perform the last operation. Ensure the select school belongs to you.");
	        	redirect($page);
        	}
	        else
	        {	
	        	//check if selected class belongs to organizer and to the selected school
        		$class_exists=$this->db->select('*')->from('Classes')->where('School',$school_exists->row()->School_id)->where('OrganizerId',$organizerid)->get();
        		if ($class_exists->num_rows()<1) 
        		{
        			$this->session->set_flashdata('message_error', "Process Failed. You do not have clearance to perform the last operation. Ensure the select class belongs to you.");
	        		redirect($page);
        		}
        		else
        		{
	        		//check if selected student belongs to organizer and to the selected school and class
	        		$student_exists=$this->db->select('*')->from('Student')->where('School_id',$school_exists->row()->School_id)->where('Class',$class_exists->row()->Class_id)->where('OrganizerId',$organizerid)->get();
	        		if ($student_exists->num_rows()<1) 
	        		{
	        			$this->session->set_flashdata('message_error', "Process Failed. You do not have clearance to perform the last operation. Ensure the select student belongs to the selected school and class, and to you. If this is an error, contact support.");
	        			redirect($page);
	        		}
	        		else
	        		{
			        	for ($i=0; $i <count($name) ; $i++) 
			        	{ 
				        	//check if score already exists
				        	$exam_exists=$this->db->select('*')->from('Result')->where('Student',$student)->where('Subject',$name[$i])->where('Session',$sess)->where('Semester',$terms)->where('School_id',$school_exists->row()->School_id)->where('OrganizerId',$organizerid)->get();
				        	if ($exam_exists->num_rows() >0) 
				        	{
				        		$this->session->set_flashdata('message_error', "Result Already Exists for the student in the selected session and term");
					        	redirect($page);	
				        	}
				        	else
				        	{
				        		$total_score=$examscore[$i]+$testscore[$i];//total score{Summation of exam score and test score}
				        		$grade=$this->db->select('*')->from('Grade')->where('Min_Score <=',$total_score)->where('Max_Score >=',$total_score)->where('School_id',$school_exists->row()->School_id)->where('OrganizerId',$organizerid)->get(); //getting grade
				        		$grades=$grade->row()->Name;
				        		$sub=$this->db->select('*')->from('Subject')->where('Subject_id',$name[$i])->where('School_id',$school_exists->row()->School_id)->where('OrganizerId',$organizerid)->get();
				        		$unit_load=$sub->row()->Unit_load;
				        		$unit_point=$unit_load*$grade->row()->Grade_point;
				        		if ($total_score >100) 
				        		{
				        			$this->session->set_flashdata('message_error', "Total Score cannot be more than 100%");
					        		redirect($page);
				        		}
				        		//passing form data into array for database insertion
					        	$result_data = array('Session' =>$sess,'Status'=>$status,'Exam_score'=>$examscore[$i],'Test_score'=>$testscore[$i],'Class'=>$class_exists->row()->Class_id,'Subject'=>$name[$i],'Semester'=>$terms,'Total_score'=>$total_score,'Student'=>$student,'Grade'=>$grades,'Gradepoint'=>$grade->row()->Grade_point,'Grade_id'=>$grade->row()->Grade_id,'Unit_load'=>$unit_load,'Unit_point'=>$unit_point,'School_id'=>$school_exists->row()->School_id,'OrganizerId'=>$organizerid);

				        		$add=$this->Organizer_model->create_result($result_data);
					        }
				        }
					    if ($add==TRUE) 
					    {
					       	$this->session->set_flashdata('message_success', "Result Successfully Added");
					        redirect($page);
					    }
					    else
					    {
					    	$this->session->set_flashdata('message_error', "Something Went Wrong. Please Try Again or Contact Support");
					        redirect($page);
					   }
					}
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
	//get result pin details through ajax request
	public function get_result_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$f_results=$this->Organizer_model->get_result_id($id,$organizerid);
		$result=$f_results->result();
		echo json_encode($result);
	}
	//delete result
	public function delete_result()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Result Pin Id', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$result_exists=$this->db->select('*')->from('Results')->where('OrganizerId',$organizerid)->where('Student',$id)->get();
        	if ($result_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Pin does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Student',$id)->where('OrganizerId',$organizerid)->delete('Result_pins');
        		if ($delete==TRUE) 
        		{
        			$this->session->set_flashdata('message_success', "Result Pin was Successfully Deleted");
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
	//delete School result
	public function delete_school_result()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('id', 'Result Pin Id', 'trim|required|numeric');
		$this->form_validation->set_rules('school', 'School', 'trim|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);

        	$id=strip_tags(html_escape($this->input->post('id')));
        	$school=strip_tags(html_escape($this->input->post('school')));

        	$school_exists=$this->db->select('*')->from('Schools')->where('School_mark',$school)->where('OrganizerId',$organizerid)->get();
        	if ($school_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message_error', "School does not exist or you have no clearance to delete data assigned to it.");
			       redirect($page);
        	}
        	else
        	{
	        	$result_exist=$this->db->select('*')->from('Result')->where('OrganizerId',$organizerid)->where('Result_id',$id)->where('School_id',$school)->get();
	        	if ($pin_exists->num_rows() <1) 
	        	{
	        		$this->session->set_flashdata('message_error', "Result does not exist or you have no clearance to delete");
			        redirect($page);
	        	}
	        	else
	        	{
	        		$delete=$this->db->where('Result_id',$id)->where('School_id',$school_exists->row()->School_id)->where('OrganizerId',$organizerid)->delete('Result_pins');
	        		if ($delete==TRUE) 
	        		{
	        			$this->session->set_flashdata('message_success', "Results assigned to school was Successfully Deleted");
			        	redirect($page);
	        		}
	        		else
	        		{
	        			$this->session->set_flashdata('message_error', "Process Failed");
			        	redirect($page);
	        		}
	        }	}
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
	public function delete_result_all()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$delete=$this->db->where('OrganizerId',$organizerid)->delete('Result_pins');
        if ($delete==TRUE) 
        {
        	$this->session->set_flashdata('message_success', "Pins Successfully deleted");
		    redirect($page);
        }
        else
        {
        	$this->session->set_flashdata('message_error', "Process Failed");
		    redirect($page);
        }
	}
}