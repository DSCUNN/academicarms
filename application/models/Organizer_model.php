<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organizer_model extends CI_Model {

/*==============================ACCOUNT CREATION MODEL============================*/
	//checking if email exists
	public function email_real($email)
	{
		return $this->db->select('*')->from('organizer')->where('Email',$email)->get();
	}
	//checking if username exists
	public function username_real($username)
	{
		return $this->db->select('*')->from('organizer')->where('Username',$username)->get();
	}
	//checking if code exists
	public function verify_code_real($email,$code)
	{
		return $this->db->select('*')->from('organizer')->where('Email',$email)->where('EmailVerifyCode',$code)->get();
	}
	//checking if code for password reset exists
	public function reset_code_real($email,$code)
	{
		return $this->db->select('*')->from('organizer')->where('Email',$email)->where('ResetCode',$code)->get();
	}
	//checking if twoway code exists
	public function verify_codelogin_real($email,$code)
	{
		return $this->db->select('*')->from('organizer')->where('Email',$email)->where('Twoway_code',$code)->get();
	}
	//for adding organizer
	public function create_organizer($data)
	{
		return $this->db->insert('organizer',$data);
	}
	public function update_organizer($data,$id)
	{
		return $this->db->set($data)->where('OrganizerId',$id)->update('organizer');
	}
	//getting loggedin Organizer
	public function Organizer_details($id,$sess)
	{
		return $this->db->select('*')->from('organizer')->where('OrganizerId',$id)->where('OrganSess',$sess)->get()->row();
	}

/*=====================================PRICING PACKAGE==========================================*/
	//getting packages
	public function get_packages()
	{
		return $this->db->select('*')->from('pricing_table')->order_by('Amount','ASC')->get();
	}
	//getting package by id
	public function get_package_id($id)
	{
		return $this->db->select('*')->from('pricing_table')->where('Package_id',$id)->get();
	}
/*===================================SCHOOLS===================================================*/
	//getting package by id
	public function get_schools($id)
	{
		return $this->db->select('*')->from('schools')->where('OrganizerId',$id)->get();
	}
	//getting package by id
	public function get_school_type($id)
	{
		return $this->db->select('*')->from('school_type')->where('OrganizerId',$id)->get();
	}
	//for adding school
	public function create_school($data)
	{
		return $this->db->insert('schools',$data);
	}
	//for adding school Type
	public function create_school_type($data)
	{
		return $this->db->insert('school_type',$data);
	}
	public function get_school_id($id,$organizerid)
	{
		return $this->db->select('*')->from('schools')->where('School_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	public function get_schooltype_id($id,$organizerid)
	{
		return $this->db->select('*')->from('school_type')->where('School_type_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	public function get_schooltype_type($type,$organizerid)
	{
		return $this->db->select('*')->from('school_type')->where('School_type_name',$type)->where('OrganizerId',$organizerid)->get();
	}
	//for updating school
	public function update_school($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('OrganizerId',$organizerid)->where('School_id',$id) ->update('schools');
	}
	//for updating school Type
	public function update_school_type($data,$id,$type)
	{
		return $this->db->set($data)->where('OrganizerId',$id)->where('School_type_id',$type)->update('school_type');
	}
/*===================================CLASSES===================================================*/
	//getting classes
	public function get_classes_grouped($organizerid)
	{
		return $this->db->select('*')->from('classes')->where('OrganizerId',$organizerid)->group_by('School','ASC')->get();
	}
	public function get_classes($organizerid)
	{
		return $this->db->select('*')->from('classes')->where('OrganizerId',$organizerid)->get();
	}
	public function get_classes_school($organizerid,$school)
	{
		return $this->db->select('*')->from('classes')->where('OrganizerId',$organizerid)->where('School',$school)->get();
	}
	//for creating class
	public function create_class($data)
	{
		return $this->db->insert('classes',$data);
	}
	public function get_class_id($id,$organizerid)
	{
		return $this->db->select('*')->from('classes')->where('Class_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for updating class
	public function update_class($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Class_id',$id)->where('OrganizerId',$organizerid)->update('classes');
	}
/*===================================TEACHERS===================================================*/
	//getting teachers
	public function get_teachers_grouped($organizerid)
	{
		return $this->db->select('*')->from('teacher')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	public function get_teachers($organizerid)
	{
		return $this->db->select('*')->from('teacher')->where('OrganizerId',$organizerid)->get();
	}
	//for creating teacher
	public function create_teachers($data)
	{
		return $this->db->insert('teacher',$data);
	}
	public function get_teacher_id($id,$organizerid)
	{
		return $this->db->select('*')->from('teacher')->where('Teacher_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	public function get_teacher_class($id,$organizerid)
	{
		return $this->db->select('*')->from('teacher')->where('Class',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for updating teachers
	public function update_teacher($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Teacher_id',$id)->where('OrganizerId',$organizerid)->update('teacher');
	}
/*===================================SUBJECTS===================================================*/
	//getting subjects
	public function get_subjects_grouped($organizerid)
	{
		return $this->db->select('*')->from('subject')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	public function get_subject_school($id,$organizerid)
	{
		return $this->db->select('*')->from('subject')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
	}
	//for creating subjects
	public function create_subjects($data)
	{
		return $this->db->insert('subject',$data);
	}
	public function get_subject_id($id,$organizerid)
	{
		return $this->db->select('*')->from('subject')->where('Subject_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for updating subjects
	public function update_subject($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Subject_id',$id)->where('OrganizerId',$organizerid)->update('subject');
	}
/*===================================SUBJECTS COMBINATION===================================================*/
	//getting subjects
	public function get_subject_combination_grouped($organizerid)
	{
		return $this->db->select('*')->from('subject_combination')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	public function get_subject_combination_school($id,$organizerid)
	{
		return $this->db->select('*')->from('subject_combination')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
	}
	//for creating subject combination
	public function create_subject_combination($data)
	{
		return $this->db->insert('subject_combination',$data);
	}
	public function get_subject_combination_id($id,$organizerid)
	{
		return $this->db->select('*')->from('subject_combination')->where('Subject_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for updating subjects
	public function update_subject_combination($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Subject_id',$id)->where('OrganizerId',$organizerid)->update('subject_combination');
	}
/*===================================STUDENTS===================================================*/
	//getting students
	public function get_students_grouped($organizerid)
	{
		return $this->db->select('*')->from('student')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	public function get_student_school($id,$organizerid)
	{
		return $this->db->select('*')->from('subject_combination')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
	}
	//for creating students
	public function create_student($data)
	{
		return $this->db->insert('student',$data);
	}
	public function get_student_id($id,$organizerid)
	{
		return $this->db->select('*')->from('student')->where('Student_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for updating student
	public function update_student($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Student_id',$id)->where('OrganizerId',$organizerid)->update('student');
	}
/*===================================ACADMIC SESSIONS===================================================*/
	//getting sessions
	public function get_sessions_grouped($organizerid)
	{
		return $this->db->select('*')->from('session')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	public function get_session_school($id,$organizerid)
	{
		return $this->db->select('*')->from('session')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
	}
	//for creating sessions
	public function create_session($data)
	{
		return $this->db->insert('session',$data);
	}
	public function get_session_id($id,$organizerid)
	{
		return $this->db->select('*')->from('session')->where('Session_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for updating session
	public function update_session($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Session_id',$id)->where('OrganizerId',$organizerid)->update('session');
	}
/*===================================ACADMIC SEMESTER===================================================*/
	//getting semester
	public function get_semester_grouped($organizerid)
	{
		return $this->db->select('*')->from('semester')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	public function get_semester_school($id,$organizerid)
	{
		return $this->db->select('*')->from('semester')->where('OrganizerId',$organizerid)->where('School_id',$id)->get();
	}
	public function get_semester_id($id,$organizerid)
	{
		return $this->db->select('*')->from('semester')->where('Semester_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	//for creating semester
	public function create_semester($data)
	{
		return $this->db->insert('semester',$data);
	}
	//for updating semester
	public function update_semester($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Semester_id',$id)->where('OrganizerId',$organizerid)->update('semester');
	}
/*====================================FOR RESULT PINS=========================*/
	//for creating result pins
	public function create_result_pin($data)
	{
		return $this->db->insert('result_pins',$data);
	}
	//for updating result Pins
	public function update_pin($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Pin_id',$id)->where('OrganizerId',$organizerid)->update('result_pins');
	}
	//for getting the resultpins by group
	public function get_pins_grouped($organizerid)
	{
		return $this->db->select('*')->from('result_pins')->where('OrganizerId',$organizerid)->group_by('School_id','ASC')->get();
	}
	//for getting the resultpins by school
	public function get_pins_school($organizerid,$school)
	{
		return $this->db->select('*')->from('result_pins')->where('OrganizerId',$organizerid)->where('School_id',$school)->get();
	}
	//for getting the resultpins by school
	public function get_pins_school_active($organizerid,$school)
	{
		return $this->db->select('*')->from('result_pins')->where('OrganizerId',$organizerid)->where('School_id',$school)->where('Status',1)->get();
	}
	public function get_pin_id($id,$organizerid)
	{
		return $this->db->select('*')->from('result_pins')->where('Pin_id',$id)->where('OrganizerId',$organizerid)->get();
	}
/*================================FAQ=========================================*/
	public function get_categories()
	{
		return $this->db->select('*')->from('faq_category')->where('Status',1)->get();
	}
	public function get_faq()
	{
		return $this->db->select('*')->from('faq')->where('Status',1)->get();
	}
	public function get_category_id($id)
	{
		return $this->db->select('*')->from('faq_category')->where('Status',1)->where('Category_id',$id)->get();
	}
	public function get_category_question_num($id)
	{
		return $this->db->select('*')->from('faq')->where('Category',$id)->get();
	}
/*================================ACCOUNT SETTINGS===========================*/
	public function email_exist_user($email,$id)
	{
		return $this->db->select('*')->from('organizer')->where('Email',$email)->where('OrganizerId!=',$id)->get();
	}
/*================================RESULTS===========================*/
	public function results_grouped($school,$id)
	{
		return $this->db->select('*')->from('result')->where('School_id',$school)->where('OrganizerId',$id)->group_by('Session')->get();
	}
	public function results_session($sess,$school,$organizer)
	{
		return $this->db->select('*')->from('result')->where('School_id',$school)->where('OrganizerId',$organizer)->where('Session',$sess)->group_by('Semester')->get();
	}
	public function results_semester($sess,$seme,$school,$organizer)
	{
		return $this->db->select('*')->from('result')->where('School_id',$school)->where('OrganizerId',$organizer)->where('Session',$sess)->where('Semester',$seme)->group_by('Class')->get();
	}
	public function results_class($sess,$seme,$class,$school,$organizer)
	{
		return $this->db->select('*')->from('result')->where('School_id',$school)->where('OrganizerId',$organizer)->where('Session',$sess)->where('Semester',$seme)->where('Class',$class)->group_by('Student')->get();
	}
	public function results_student($sess,$seme,$class,$stud,$school,$organizer)
	{
		return $this->db->select('*')->from('result')->where('School_id',$school)->where('OrganizerId',$organizer)->where('Session',$sess)->where('Semester',$seme)->where('Student',$stud)->where('Class',$class)->get();
	}
	public function get_result_id($id,$organizer)
	{
		return $this->db->select('*')->from('result')->join('Subject','Subject.Subject_id=Result.Subject')->where('Result_id',$id)->where('Result.OrganizerId',$organizer)->get();
	}
	public function create_result($data)
	{
		return $this->db->insert('result',$data);
	}
	public function update_result($data,$id,$organizer)
	{
		return $this->db->set($data)->where('Result_id',$id)->where('OrganizerId',$organizer)->update('result');
	}
/*================================GRADES===========================*/
	public function grade_grouped($id)
	{
		return $this->db->select('*')->from('grade')->where('OrganizerId',$id)->group_by('School_id')->get();
	}
	public function get_grade_id($id,$organizer)
	{
		return $this->db->select('*')->from('grade')->where('Grade_id',$id)->where('OrganizerId',$organizer)->get();
	}
	public function Create_grade($data)
	{
		return $this->db->insert('grade',$data);
	}
	public function update_grade($data,$id,$organizer)
	{
		return $this->db->set($data)->where('Grade_id',$id)->where('OrganizerId',$organizer)->update('grade');
	}
/*==============================RESULT TYPE===============================*/
	public function types_grouped($id)
	{
		return $this->db->select('*')->from('result_type')->where('OrganizerId',$id)->group_by('School_id')->get();
	}
	public function create_result_type($data)
	{
		return $this->db->insert('result_type',$data);
	}
	public function get_result_type_id($id)
	{
		return $this->db->select('*')->from('result_type')->where('Type_id',$id)->get();
	}
	public function update_result_type($data,$id)
	{
		return $this->db->set($data)->where('Type_id',$id)->update('result_type');
	}
/*==============================POSITION===============================*/
	public function position_grouped($id)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->group_by('School_id')->get();
	}
	public function position_school($school,$id)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->where('School_id',$school)->group_by('Session')->get();
	}
	public function position_session($school,$id,$sess)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->where('School_id',$school)->where('Session',$sess)->group_by('Term')->get();
	}
	public function position_semester($session_mk,$semester_mk,$school,$id)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->where('School_id',$school)->where('Session',$session_mk)->where('Term',$semester_mk)->group_by('Class')->get();
	}
	public function position_class($session_mk,$semester_mk,$class_mk,$school,$id)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->where('School_id',$school)->where('Session',$session_mk)->where('Term',$semester_mk)->where('Class',$class_mk)->group_by('Student')->get();
	}
	public function position_student($session_mk,$semester_mk,$class_mk,$stud,$school,$id)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->where('School_id',$school)->where('Session',$session_mk)->where('Term',$semester_mk)->where('Class',$class_mk)->where('Student',$stud)->group_by('Result_type')->get();
	}
	public function position_type($session_mk,$semester_mk,$class_mk,$stud,$result_type,$school,$id)
	{
		return $this->db->select('*')->from('position')->where('OrganizerId',$id)->where('School_id',$school)->where('Session',$session_mk)->where('Term',$semester_mk)->where('Class',$class_mk)->where('Student',$stud)->where('Result_type',$result_type)->get();
	}
	public function create_position($data)
	{
		return $this->db->insert('position',$data);
	}
	public function get_position_id($id)
	{
		return $this->db->select('*')->from('position')->where('Position_id',$id)->get();
	}
	public function update_position($data,$id)
	{
		return $this->db->set($data)->where('Position_id',$id)->update('position');
	}

/*=============================== PAYMENTS==================================*/
	public function add_transaction($data)
	{
		return $this->db->insert('payments',$data);
	}
	public function get_payments($organizerid)
	{
		return $this->db->select('*')->from('payments')->where('OrganizerId',$organizerid)->get();
	}
	public function get_payment_id($id,$organizerid)
	{
		return $this->db->select('*')->from('payments')->where('Payment_id',$id)->where('OrganizerId',$organizerid)->get();
	}
	public function update_payment($data,$id,$organizerid)
	{
		return $this->db->set($data)->where('Payment_id',$id)->where('OrganizerId',$organizerid)->update('payments');
	}


/*================================OTHERS======================================*/

	//for creating position
	public function add_position($data)
	{
		return $this->db->insert('position',$data);
	}
	//getting teachers
	public function get_teacher()
	{
		return $this->db->select('*')->from('teacher')->order_by('Name','ASC')->get();
	}
	//getting result type
	public function get_result_type()
	{
		return $this->db->select('*')->from('result_type')->order_by('Name','ASC')->get();
	}
	//for creating teacher
	public function create_teacher($data)
	{
		return $this->db->insert('teacher',$data);
	}
	//for creating admin
	public function create_admin($data)
	{
		return $this->db->insert('Sysadmin',$data);
	}
	//getting result pins
	public function get_result_pins()
	{
		return $this->db->select('*')->from('Result_Pins')->order_by('Pin_id','ASC')->get();
	}
	//getting system administrator
	public function get_admin($admin)
	{
		return $this->db->select('*')->from('Sysadmin')->where('Admin_type!=',1) ->where('admin_id!=',$admin)->get();
	}
	
	//for creating subject
	public function create_subject($data)
	{
		return $this->db->insert('Subject',$data);
	}
	//for creating teacher batch
	public function create_teacher_batch($data)
	{
		return $this->db->insert('Teacher',$data);
	}
	//for creating subject batch
	public function create_subject_batch($data)
	{
		return $this->db->insert('Subject',$data);
	}
	//for creating subject combination batch
	public function create_subjectcom_batch($data)
	{
		return $this->db->insert('Subject_combination',$data);
	}
	//for updating admin
	public function update_admin($data,$id)
	{
		return $this->db->set($data)->where('admin_id',$id)->update('Sysadmin');
	}
	//getting Subjects
	public function get_subject()
	{
		return $this->db->select('*')->from('Subject')->order_by('Subject_id','ASC')->get();
	}
	//getting Subject combination
	public function get_subject_combination($class)
	{
		return $this->db->select('*')->from('Subject_combination')->where('Class',$class)->get();
	}
	//getting students from all class
	public function get_students_all()
	{
		return $this->db->select('*')->from('Student')->get();
	}
	//getting sessions
	public function get_session()
	{
		return $this->db->select('*')->from('Session')->get();
	}
	//getting semester
	public function get_semester()
	{
		return $this->db->select('*')->from('Semester')->get();
	}
	//getting grades
	public function get_grade()
	{
		return $this->db->select('*')->from('Grade')->get();
	}
	//getting result
	public function get_result()
	{
		return $this->db->select('*')->from('Result')->group_by('Session')->get();
	}
	//getting result
	public function get_result_session($id)
	{
		return $this->db->select('*')->from('Result')->where('Session',$id)->group_by('Semester')->get();

	}
	//getting result
	public function get_result_term($sess,$term)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->group_by('Class')->get();

	}
	//getting result
	public function get_result_class($sess,$term,$class)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->group_by('Student')->get();

	}
	//getting result
	public function get_result_student($sess,$term,$class,$stud)
	{
		return $this->db->select('*')->from('Result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->where('Student',$stud)->group_by('Subject')->get();

	}
	//getting students for selected class
	public function get_students($class)
	{
		return $this->db->select('*')->from('Student')->where('Class',$class) ->get();
	}
	//getting positions
	public function get_position()
	{
		return $this->db->select('*')->from('Position')->group_by('Session')->get();
	}
	//getting position
	public function get_position_session($id)
	{
		return $this->db->select('*')->from('Position')->where('Session',$id)->group_by('Term')->get();
	}
	//getting position
	public function get_position_term($sess,$term)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->group_by('Class')->get();
	}
	//getting position
	public function get_position_class($sess,$term,$class)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->group_by('Student')->get();
	}
	//getting position
	public function get_position_student($sess,$term,$class,$stud)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('Student',$stud)->group_by('Result_type')->get();
	}
	//getting position
	public function get_position_student_type($sess,$term,$class,$stud,$type)
	{
		return $this->db->select('*')->from('Position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('Student',$stud)->where('Result_type',$type)->get();

	}
	//for updating site settings
	public function update_site($data)
	{
		return $this->db->set($data)->where('id',1)->update('general_settings');
	}
	//for updating admin profile
	public function update_admin_profile($data,$id)
	{
		return $this->db->set($data)->where('admin_id',$id)->update('Sysadmin');
	}
}