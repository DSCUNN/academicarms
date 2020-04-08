<?php
defined('BASEPATH') OR exit('Access denied');

class Result_pins extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
	}
	public function index($page='account/result_pins')
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
        $package=$this->Organizer_model->get_package_id($organizer->Active_package);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['package']=$package->row();
		$data['resultpins']=$this->Organizer_model->get_pins_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['payment_methods']=$this->db->select('*')->from('paymentmethod')->where('Status',1)->get();
		$data['Page_name']='Result Pins';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/result_pins_footer',$data);
	}
	public function authenticate()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
		$this->form_validation->set_rules('pin_number', 'Number of Pins', 'trim|required|numeric');
		$this->form_validation->set_rules('school', 'School Name', 'trim|required|numeric');
		$this->form_validation->set_rules('amount', 'Amount to Pay', 'trim|required|numeric');
		$this->form_validation->set_rules('payment_method', 'Payment method', 'trim|required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$organizerid=$this->session->userdata('Organid');
			$organsess=$this->session->userdata('OrganSess');
			$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
        	//submitted requests
        	$pin=html_escape($this->input->post('pin_number'));
        	$amount=html_escape($this->input->post('amount'));
        	$school=html_escape($this->input->post('school'));
        	$status=html_escape($this->input->post('status'));
        	$payment_method=html_escape($this->input->post('payment_method'));

        	$package=$this->Organizer_model->get_package_id($organizer->Active_package);
        	$price=$package->row()->New_price;
        	$amt_to_pay=$pin*$price;
        	$schools_exist=$this->db->select('*')->from('Schools')->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
        	//check if payment method supplied is recognized by system
        	$paymentmethod_exists=$this->Admin_model->get_payment_method_id($payment_method);
        	if ($paymentmethod_exists->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message_error', "Selected Payment method Does not exist on the system.");
	            redirect($page);
        	}

        	if ($schools_exist->num_rows()<1) 
        	{
        		$this->session->set_flashdata('message_error', "Process Failed.School selected does not belong to you");
	            redirect($page);
        	}
        	if ($amt_to_pay > $amount) 
        	{
        		$this->session->set_flashdata('message_error', "Process Failed. Do not alter the prices on this system. The Amount to pay cannot be less than the system amount.");
	            redirect($page);
        	}
        	elseif ($amt_to_pay < $amount) 
        	{
        		$this->session->set_flashdata('message_error', "Process Failed. Do not alter the prices on this system. The Amount to pay cannot be greater than the system amount.");
	            redirect($page);
        	}
        	else
        	{
        		$balance=$organizer->Balance;
        		if ($paymentmethod_exists->row()->MethodId==3 && $balance<$amt_to_pay)
	        	{
	        		$this->session->set_flashdata('message_error', "Process Failed. You have an insufficient fund in your account to make this purchase.");
	            	redirect($page);
	        	}
        		$data_session = array('Number_of_pin' =>$pin,'Amount_to_pay'=>$amt_to_pay,'School_associated'=>$schools_exist->row()->School_id,'Set_pin_session'=>true,'Payment_method'=>$paymentmethod_exists->row());
        		$this->session->set_userdata($data_session);
        		if ($this->session->has_userdata('Set_pin_session')) 
        		{
        			redirect('account/result_pins/preview_payment');
        		}
        		else
        		{
        			$this->session->set_flashdata('message_error', "Process failed. We were unable to initialize your payment page.");
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
	public function preview_payment($page='account/preview_payment')
	{

		if (!$this->session->userdata('Set_pin_session')) 
		{
			$this->session->set_flashdata('message_error', "Process failed. Page could not be opened. Try again");
	        redirect('account/result_pins');
		}
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
        $package=$this->Organizer_model->get_package_id($organizer->Active_package);
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['package']=$package->row();
		$data['payment_method']=$this->session->userdata('Payment_method');
		$data['resultpins']=$this->Organizer_model->get_pins_grouped($organizerid);
		$data['schools']=$this->Organizer_model->get_schools($organizerid);
		$data['Page_name']='Payment Previews';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($page,$data);
		$this->load->view('account/templates/result_pins_footer',$data);
	}
	public function view_pins($id=null)
	{
		$pages='account/view_pins';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school Result Pins");
	        redirect($page);
		}
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['school_mk']=$id;
		$data['pins']=$this->Organizer_model->get_pins_school($organizerid,$schools->row()->School_id);
		$data['Page_name']='View Result Pins';
		$this->load->view('account/templates/header',$data);
		$this->load->view('account/templates/sidemenu',$data);
		$this->load->view('account/templates/topmenu',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/result_pins_footer',$data);	
	}
	public function print_pin($id=null)
	{
		$pages='account/print_pins';
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$schools=$this->db->select('*')->from('Schools')->where('School_mark',$id)->where('OrganizerId',$organizerid)->get();

		if ($schools->num_rows()<1) 
		{
			$this->session->set_flashdata('message_error', "We couldn't find requested school Result Pins");
	        redirect($page);
		}
		$data['general_settings']=$general_settings;
		$data['organizer']=$organizer;
		$data['school_mk']=$id;
		$data['pins']=$this->Organizer_model->get_pins_school_active($organizerid,$schools->row()->School_id);
		$data['Page_name']='Print Result Pins';
		$this->load->view('account/templates/print_header',$data);
		$this->load->view($pages,$data);
		$this->load->view('account/templates/print_result_footer',$data);	
	}
	public function Edit_pin()
	{
		$page=$_SERVER['HTTP_REFERER'];
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		//Set Form Validation Rules
        $this->form_validation->set_rules('status', 'Status', 'trim|required|numeric');
        $this->form_validation->set_rules('id','Pin Id','trim|required|numeric');
		if ($this->form_validation->run() == TRUE)
        {
        	$status=html_escape($this->input->post('status'));
        	$pin=html_escape($this->input->post('id'));
        	//check if class already exists
        	$pin_exists=$this->db->select('*')->from('Result_pins')->where('Status',$status)->where('Pin_id',$pin)->where('OrganizerId',$organizerid)->get();
        	if ($pin_exists->num_rows() >0) 
        	{
        		$this->session->set_flashdata('message_error', "Action already taken.");
	        	redirect($page);	
        	}
        	else
        	{
	        	//passing form data into array for database insertion
	        	$pin_data = array('Status'=>$status);
	        	$update=$this->Organizer_model->update_pin($pin_data,$pin,$organizerid);
	        	if ($update==TRUE) 
	        	{
	        		$this->session->set_flashdata('message_success', "Result Pin Successfully Updated.");
	        		redirect($page);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Something Went Wrong. Please Try Again.");
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
	//get result pin details through ajax request
	public function get_pin_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$class=$this->Organizer_model->get_pin_id($id,$organizerid);
		$result=$class->result();
		echo json_encode($result);
	}
	//get package according to the user active package
	public function get_package_id($id)
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$package=$this->Organizer_model->get_package_id($id,$organizerid);
		$result=$package->result();
		echo json_encode($result);
	}
	//delete class
	public function delete_pin()
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
        	$pin_exists=$this->db->select('*')->from('Result_pins')->where('OrganizerId',$organizerid)->where('Pin_id',$id)->get();
        	if ($pin_exists->num_rows() <1) 
        	{
        		$this->session->set_flashdata('message_error', "Pin does not exist or you have no clearance to delete");
		        redirect($page);
        	}
        	else
        	{
        		$delete=$this->db->where('Pin_id',$id)->where('OrganizerId',$organizerid)->delete('Result_pins');
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
	public function delete_pin_all()
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
	public function authenticate_paystacks()
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$page=$_SERVER['HTTP_REFERER'];
		//Set Form Validation Rules
        $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$amount=$this->security->xss_clean($this->input->post('amount'));
        	$main_amount=$this->security->xss_clean($this->session->userdata('Amount_to_pay'));
        	if ($amount<$main_amount) 
        	{
        		$this->session->set_flashdata('message_error', "Process Failed. Amount does not correspond.");
		    	redirect($page);
        	}
        	//user details
        	$user_id=$organizer->OrganizerId;
        	$payment_gate=$this->session->userdata('Payment_method');
        	$payment_method=$payment_gate->MethodId;
        	$payment_ref=rand(1000000,9999999999);
        	$trans_code=$general_settings->row()->Site_shortname.'-'.time();
        	//processing payment
        	if ($payment_method==1)
	        {
	        	$data_array  = array('OrganizerId' =>$user_id,'Amount_paid'=>$amount,'Payment_method'=>$payment_method,'Payment_Ref'=>$payment_ref,'Transaction_id'=>$trans_code,'Date_payment'=>time(),'Payment_Status'=>5);
	        	$added=$this->Organizer_model->add_transaction($data_array,$userid);
	        	if ($added==true) 
	        	{
	        		$result = array();
								$ref=$payment_ref;
				                $amount = $amount * 100;
				                $callback_url = base_url().'account/result_pins/verify_payment/'.$ref;
				                $postdata =  array('email' => $organizer->Email, 'amount' => $amount,"reference" => $ref, "callback_url" => $callback_url);
				                //
				                $url = "https://api.paystack.co/transaction/initialize";
				                $ch = curl_init();
				                curl_setopt($ch, CURLOPT_URL,$url);
				                curl_setopt($ch, CURLOPT_POST, 1);
				                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
				                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				                //
				                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				                $headers = [
				                    'Authorization: Bearer '.PAYSTACK_SECRET_KEY,
				                    'Content-Type: application/json',
				                ];
				                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				                $request = curl_exec ($ch);
				                curl_close ($ch);
				                //
				                if ($request) {
				                    $result = json_decode($request, true);
				                }

				                $redir = $result['data']['authorization_url'];
				                 header("Location: ".$redir);
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Deposit process failed. Try again");
           			redirect($page);
	        	}
	        }
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span><i class='fa fa-info-circle'></i> $errors</span></div>");
        	redirect($page);
        }
	}
	private function getPaymentInfo($ref) {
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/'.$ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.PAYSTACK_SECRET_KEY]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        $result = json_decode($request, true);
        //
        return $result['data'];

    }
    public function verify_payment($ref) {
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/'.$ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.PAYSTACK_SECRET_KEY]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        if ($request) {
            $result = json_decode($request, true);
            // print_r($result);
            if($result){
                if($result['data']){
                    //something came in
                    if($result['data']['status'] == 'success'){

                        //echo "Transaction was successful";
                        header("Location: ".base_url().'account/result_pins/success/'.$ref);

                    }else{
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        header("Location: ".base_url().'account/result_pins/fail/'.$ref);

                    }
                }
                else{

                    //echo $result['message'];
                    header("Location: ".base_url().'account/result_pins/fail/'.$ref);
                }

            }else{
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                header("Location: ".base_url().'account/result_pins/fail/'.$ref);
            }
        }else{
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            header("Location: ".base_url().'account/result_pins/fail/'.$ref);
        }

    }
    public function success($ref) {
    	$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

        $data = array();
        $info = $this->getPaymentInfo($ref);
         //
        $data['title'] = "Paystack InLine Demo";
        $data['amount'] = $info['amount']/100;
        //updating payment status
        $refs=$this->security->xss_clean($ref);
        $payments=$this->db->select('*')->from('payments')->where('Payment_Ref',$refs)->where('OrganizerId',$organizerid)->get();//get payments
        if ($payments->row()->Payment_Status==1) 
        {
        	$this->session->set_flashdata('message_error', "Your Payment had been approved and pin generated.");
			redirect('account/result_pins');
        }
        else
        {
        	
        		$pin=$this->session->userdata('Number_of_pin');
        		$school=$this->session->userdata('School_associated');
        		$schools_exist=$this->db->select('*')->from('Schools')->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
        		for ($i=0; $i < $pin; $i++) 
	        	{ 
	        		//getting length of pin and serial number
			    	$pin_length=$schools_exist->row()->Resultpin_length;
			    	$serial_length=$schools_exist->row()->Serialpin_length;
			    	//getting pin and serial combination
			    	$pin_char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    	$serial_char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			    	//shuffling
	                $pins= substr(str_shuffle($pin_char), 0,$pin_length);
	                $serialnum= substr(str_shuffle($serial_char), 0, $serial_length);

	                $pin_data = array('Pin_number'=>$pins,'Serial_number'=>$serialnum, 'Status'=>1,'OrganizerId'=>$organizerid,'School_id'=>$school);
	        		$add=$this->Organizer_model->create_result_pin($pin_data);
	        	}
	        	if ($add==TRUE) 
	        	{
	        		$payment_status = array('Payment_Status' => 1);
        			$update_payment=$this->db->set($payment_status)->where('Payment_Ref',$payments->row()->Payment_Ref)->where('OrganizerId',$organizerid)->update('payments');
	        		$this->session->set_flashdata('message_success', "Result Pins successfully added");
		            redirect('account/result_pins');
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Process Failed");
		            redirect('account/result_pins');
	        	}
        }
    }
    public function fail($ref) 
    {
    	$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

        //updating payment status
        $refs=$this->security->xss_clean($ref);
        $payments=$this->db->select('*')->from('payments')->where('Payment_Ref',$refs)->where('OrganizerId',$organizerid)->get();//get payments
        if ($payments->row()->Payment_Status==1) 
        {
        	$this->session->set_flashdata('message_error', "Your Payment had been approved.");
			redirect('account/result_pins');
        }
        else
        {
        	
        	$payment_status = array('Payment_Status' => 3);
        	$update_payment=$this->db->set($payment_status)->where('Payment_Ref',$payments->row()->Payment_Ref)->where('OrganizerId',$organizerid)->update('payments');
        	if ($update_payment==true) 
        	{
        		$this->session->set_flashdata('message_success', "Your Payment was failed.");
				redirect('account/result_pins');
        	}
        }
    }
    public function account_balance()
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$page=$_SERVER['HTTP_REFERER'];
		//Set Form Validation Rules
        $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
		if ($this->form_validation->run() == TRUE)
        {
        	$amount=$this->security->xss_clean($this->input->post('amount'));

        	//user details
        	$user_id=$organizer->OrganizerId;
        	$payment_gate=$this->session->userdata('Payment_method');
        	$payment_method=$payment_gate->MethodId;
        	$payment_ref=rand(1000000,9999999999);
        	$trans_code=$general_settings->row()->Site_shortname.'-'.time();
        	//processing payment
        	if ($payment_method==3)
	        {
	        	$data_array  = array('OrganizerId' =>$user_id,'Amount_paid'=>$amount,'Payment_method'=>$payment_method,'Payment_Ref'=>$payment_ref,'Transaction_id'=>$trans_code,'Date_payment'=>time(),'Payment_Status'=>1);
	        	$added=$this->Organizer_model->add_transaction($data_array,$userid);
	        	if ($added==true) 
	        	{
	        		$balance=$organizer->Balance;
	        		$new_balance=$balance-$amount;
	        		$pin=$this->session->userdata('Number_of_pin');
	        		$school=$this->session->userdata('School_associated');
	        		$schools_exist=$this->db->select('*')->from('Schools')->where('School_id',$school)->where('OrganizerId',$organizerid)->get();
	        		for ($i=0; $i < $pin; $i++) 
		        	{ 
		        		//getting length of pin and serial number
				    	$pin_length=$schools_exist->row()->Resultpin_length;
				    	$serial_length=$schools_exist->row()->Serialpin_length;
				    	//getting pin and serial combination
				    	$pin_char = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				    	$serial_char='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				    	//shuffling
		                $pins= substr(str_shuffle($pin_char), 0,$pin_length);
		                $serialnum= substr(str_shuffle($serial_char), 0, $serial_length);

		                $pin_data = array('Pin_number'=>$pins,'Serial_number'=>$serialnum, 'Status'=>1,'OrganizerId'=>$organizerid,'School_id'=>$school);
		        		$add=$this->Organizer_model->create_result_pin($pin_data);
		        	}
		        	if ($add==TRUE) 
		        	{
		        		$organizer_data = array('Balance' => $new_balance);
	        			$this->Organizer_model->update_organizer($organizer_data,$organizerid);
		        		$this->session->set_flashdata('message_success', "Result Pins successfully added");
			            redirect('account/result_pins');
		        	}
		        	else
		        	{
		        		$this->session->set_flashdata('message_error', "Process Failed");
			            redirect('account/result_pins');
		        	}
	        	}
	        	else
	        	{
	        		$this->session->set_flashdata('message_error', "Checkout process failed. Try again");
           			redirect($page);
	        	}
	        }
	        else
	        {
	        	$this->session->set_flashdata('message_error', "Checkout process failed. Try again or contact support");
           		redirect('account/result_pins');
	        }
        }
        else
        {
        	$errors=validation_errors();
        	$this->session->set_flashdata('message', "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button><span><i class='fa fa-info-circle'></i> $errors</span></div>");
        	redirect($page);
        }
	}
}