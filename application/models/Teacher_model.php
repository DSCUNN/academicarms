<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model {

	//checking if email exists
	public function email_real($email)
	{
		return $this->db->select('*')->from('teacher')->where('Email',$email)->get();
	}
	//check for coherent school and email
	public function email_real_school($email,$school)
	{
		return $this->db->select('*')->from('teacher')->where('Email',$email)->where('School_id',$school)->get();
	}
	//check if code matches
	public function reset_code_real($email,$code)
	{
		return $this->db->select('*')->from('teacher')->where('Email',$email)->where('Email_code',$code)->get();
	}
	//getting loggedin teacher
	public function Teacher_details($id,$sess)
	{
		return $this->db->select('*')->from('teacher')->where('Teacher_id',$id)->where('TeacherSess',$sess)->get();
	}
	//updating teacher
	public function update_teacher($data,$teacher)
	{
		return $this->db->set($data)->where('Teacher_id',$teacher)->update('teacher');
	}
	//getting classes
	public function get_classes($teacherclass)
	{
		return $this->db->select('*')->from('classes')->where('Class_id',$teacherclass)->order_by('Name','ASC')->get();
	}
	//for updating result
	public function update_result($data,$id)
	{
		return $this->db->set($data)->where('Result_id',$id)->update('result');
	}
	//getting result type
	public function get_result_type()
	{
		return $this->db->select('*')->from('result_type')->order_by('Name','ASC')->get();
	}
	//for updating positions
	public function update_position($data,$id)
	{
		return $this->db->set($data)->where('Position_id',$id)->update('position');
	}
	//getting Subjects
	public function get_subject($class)
	{
		return $this->db->select('*')->from('subject_combination')->join('subject','Subject.Subject_id=Subject_combination.Subject')->where('Class',$class)->order_by('Subject_id','ASC')->get();
	}
	//getting subjects
	public function get_subject_combination_grouped($organizerid,$class)
	{
		return $this->db->select('*')->from('subject_combination')->where('OrganizerId',$organizerid)->where('Class',$class)->group_by('Class','ASC')->get();
	}
	public function get_subject_combination($organizerid,$class)
	{
		return $this->db->select('*')->from('subject_combination')->where('OrganizerId',$organizerid)->where('Class',$class)->get();
	}
	//getting students in class
	public function get_students_class($class)
	{
		return $this->db->select('*')->from('student')->where('Class',$class)->get();
	}
	public function get_students_class_grouped($class)
	{
		return $this->db->select('*')->from('student')->where('Class',$class)->group_by('Class')->get();
	}
	public function get_classes_school($organizerid,$school,$class)
	{
		return $this->db->select('*')->from('classes')->where('OrganizerId',$organizerid)->where('School',$school)->where('Class_id',$class)->get();
	}
	//getting sessions
	public function get_session()
	{
		return $this->db->select('*')->from('session')->get();
	}
	//getting semester
	public function get_semester()
	{
		return $this->db->select('*')->from('semester')->get();
	}
	//getting result
	public function get_result($class)
	{
		return $this->db->select('*')->from('result')->where('Class',$class)->group_by('Session')->get();
	}
	//getting result
	public function get_result_session($id,$class)
	{
		return $this->db->select('*')->from('result')->where('Session',$id)->where('Class',$class)->group_by('Semester')->get();

	}
	//getting result
	public function get_result_term($sess,$term,$class)
	{
		return $this->db->select('*')->from('result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->group_by('Class')->get();

	}
	//getting result
	public function get_result_class($sess,$term,$class)
	{
		return $this->db->select('*')->from('result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->group_by('Student')->get();

	}
	//getting result
	public function get_result_student($sess,$term,$class,$stud)
	{
		return $this->db->select('*')->from('result')->where('Session',$sess)->where('Semester',$term)->where('Class',$class)->where('Student',$stud)->group_by('Subject')->get();

	}
	//for creating students
	public function create_student($data)
	{
		return $this->db->insert('student',$data);
	}
	//for creating result
	public function create_result($data)
	{
		return $this->db->insert('result',$data);
	}
	//getting positions
	public function get_position($class,$school)
	{
		return $this->db->select('*')->from('position')->where('Class',$class)->where('School_id',$school)->group_by('Session')->get();
	}
	//getting position
	public function get_position_session($id,$class,$school)
	{
		return $this->db->select('*')->from('position')->where('Session',$id)->where('Class',$class)->where('School_id',$school)->group_by('Term')->get();
	}
	//getting position
	public function get_position_term($sess,$term,$class,$school)
	{
		return $this->db->select('*')->from('position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('School_id',$school)->group_by('Class')->get();
	}
	//getting position
	public function get_position_class($sess,$term,$class,$school)
	{
		return $this->db->select('*')->from('position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('School_id',$school)->group_by('Student')->get();
	}
	//getting position
	public function get_position_student($sess,$term,$class,$stud,$school)
	{
		return $this->db->select('*')->from('position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('School_id',$school)->where('Student',$stud)->group_by('Result_type')->get();
	}
	//getting position
	public function get_position_student_type($sess,$term,$class,$stud,$type,$school)
	{
		return $this->db->select('*')->from('position')->where('Session',$sess)->where('Term',$term)->where('Class',$class)->where('School_id',$school)->where('Student',$stud)->where('Result_type',$type)->get();

	}
}