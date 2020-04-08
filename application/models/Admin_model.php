<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

/*==============================ADMIN ACCOUNT============================*/
	//checking if email exists
	public function email_real($email)
	{
		return $this->db->select('*')->from('sysadmin')->where('Email',$email)->get();
	}
	//checking if code exists
	public function verify_code_real($email,$code)
	{
		return $this->db->select('*')->from('sysadmin')->where('Email',$email)->where('Email_code',$code)->get();
	}
	//checking if code for password reset exists
	public function reset_code_real($email,$code)
	{
		return $this->db->select('*')->from('sysadmin')->where('Email',$email)->where('ResetCode',$code)->get();
	}
	//checking if twoway code exists
	public function verify_codelogin_real($email,$code)
	{
		return $this->db->select('*')->from('sysadmin')->where('Email',$email)->where('Twoway_code',$code)->get();
	}
	public function update_admin($data,$id)
	{
		return $this->db->set($data)->where('admin_id',$id)->update('sysadmin');
	}
	//getting loggedin Admin
	public function admin_details($id,$sess)
	{
		return $this->db->select('*')->from('sysadmin')->where('admin_id',$id)->where('AdminSess',$sess)->get()->row();
	}
/*==============================ORGANIZERS ACCOUNT==============================*/
	public function get_organizers()
	{
		return $this->db->select('*')->from('organizer')->order_by('OrganizerId','DESC')->get();
	}
	public function get_organizer_id($id)
	{
		return $this->db->select('*')->from('organizer')->where('OrganizerId',$id)->get();
	}
	public function get_schools()
	{
		return $this->db->select('*')->from('schools')->get();
	}
/*==========================RESULT PINS ========================================*/
	public function get_result_pins()
	{
		return $this->db->select('*')->from('result_pins')->order_by('Pin_id','ASC')->get();
	}
	public function get_result_pins_id($id)
	{
		return $this->db->select('*')->from('result_pins')->where('Pin_id',$id)->get();
	}
	public function update_result_pin($data,$id)
	{
		return $this->db->set($data)->where('Pin_id',$id)->update('result_pins');
	}
	public function pin_usage($id)
	{
		return $this->db->select('*')->from('pin_usage')->where('Pin_id',$id)->get();
	}
/*=============================PRICING PLAN=====================================*/
	public function get_pricing_plans()
	{
		return $this->db->select('*')->from('pricing_table')->order_by('Package_id','DESC')->get();
	}
	public function get_pricing_plan_id($id)
	{
		return $this->db->select('*')->from('pricing_table')->where('Package_id',$id)->get();
	}
	public function update_pricing_plan($data,$id)
	{
		return $this->db->set($data)->where('Package_id',$id)->update('pricing_table');
	}
	public function create_pricing_plan($data)
	{
		return $this->db->insert('pricing_table',$data);
	}
/*========================== FAQ CATEGORY =======================================*/
	public function get_faq_category()
	{
		return $this->db->select('*')->from('faq_category')->get();
	}
	public function get_faq_category_id($id)
	{
		return $this->db->select('*')->from('faq_category')->where('Category_id',$id)->get();
	}
	public function create_faq_category($data)
	{
		return $this->db->insert('faq_category',$data);
	}
	public function update_faq_category($data,$id)
	{
		return $this->db->set($data)->where('Category_id',$id)->update('faq_category');
	}
/*=============================FAQ=============================================*/
	public function get_faq()
	{
		return $this->db->select('*')->from('faq')->get();
	}
	public function get_faq_id($id)
	{
		return $this->db->select('*')->from('faq')->where('Faq_id',$id)->get();
	}
	public function create_faq($data)
	{
		return $this->db->insert('faq',$data);
	}
	public function update_faq($data,$id)
	{
		return $this->db->set($data)->where('Faq_id',$id)->update('faq');
	}
/*=============================FAQ REQUEST=============================================*/
	public function get_faq_request()
	{
		return $this->db->select('*')->from('faq_request')->get();
	}
	public function get_faq_request_id($id)
	{
		return $this->db->select('*')->from('faq_request')->where('Request_id',$id)->get();
	}
/*=========================GENERAL SETTINGS ==========================================*/
	public function update_settings($data)
	{
		return $this->db->set($data)->where('id',1)->update('general_settings');
	}
/*======================== PAYMENT METHODS ==========================================*/
	public function get_payment_methods()
	{
		return $this->db->select('*')->from('paymentmethod')->get();
	}
	public function get_payment_method_id($id)
	{
		return $this->db->select('*')->from('paymentmethod')->where('MethodId',$id)->get();
	}
	public function update_payment_method($data,$id)
	{
		return $this->db->set($data)->where('MethodId',$id)->update('paymentmethod');
	}
/*=====================PAYMENTS ======================================================*/
	public function get_payments()
	{
		return $this->db->select('*')->from('payments')->get();
	}
	public function get_payment_id($id)
	{
		return $this->db->select('*')->from('payments')->where('Payment_id',$id)->get();
	}
	public function update_payment($data,$id)
	{
		return $this->db->set($data)->where('Payment_id',$id)->update('payments');
	}
}