<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Flutter Wave Library for CodeIgniter 3.X.X
 *
 * Library for Flutter Wave payment gateway. It helps to integrate Flutter Wave payment gateway's Standard Method
 * in the CodeIgniter application.
 *
 * It requires Flutterwave configuration file and it should be placed in the config directory.
 *
 * @package     CodeIgniter
 * @category    Libraries
 * @author      Jaydeep Goswami
 * @link        https://infinitietech.com
 * @GITHUB link https://github.com/jaydeepgiri/Flutterwave-Payments-CodeIgniter-3.X.X-Library
 * @license     https://github.com/jaydeepgiri/Flutterwave-Payments-CodeIgniter-3.X.X-Library/blob/master/LICENSE
 * @version     1.0
 */

class Flutterwave extends CI_Controller {
	
	protected $response = '';
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('OrganSess')){
			$this->session->set_flashdata('message_error', "You do not have access to page. Either your session has expired or you were never logged in. Login to continue.");
            redirect('login');
		}
		$this->load->library(['flutterwave_lib','session']);
		
	}
	public function create_transaction()
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();
		$page=$_SERVER['HTTP_REFERER'];

		$data = $this->input->post();
		echo "<pre>";
		// print_r($data);
		$data = array(
			'amount'=>$data['amount'],
			'customer_email' => $data['email'],
			'redirect_url'=>base_url("account/flutterwave/payment_status/"),
			'txref'=>rand(1000000,9999999999)
		);
		$payment_gate=$this->session->userdata('Payment_method');
        $payment_method=$payment_gate->MethodId;
        $trans_code=$general_settings->row()->Site_shortname.'-'.time();
		$this->response = $this->flutterwave_lib->create_payment($data);
		print_r($this->response);
		if(!empty($this->response) || $this->response != '')
		{
			$this->response = json_decode($this->response,1);
			if(isset($this->response['status']) && $this->response['status'] == 'success')
			{
				$data_array  = array('OrganizerId' =>$organizerid,'Amount_paid'=>$data['amount'],'Payment_method'=>$payment_method,'Payment_Ref'=>$data['txref'],'Transaction_id'=>$trans_code,'Date_payment'=>time(),'Payment_Status'=>5);
	        	$added=$this->Organizer_model->add_transaction($data_array,$organizerid);
				redirect($this->response['data']['link']);
			}
			else
			{
				$this->session->set_flashdata('message_error', 'Payment did not work');
				redirect(base_url('account/result_pins/'));
			}
		}
		// $this->load->view('flutterwave/payment_form');
	}
	public function payment_status()
	{
		$organizerid=$this->session->userdata('Organid');
		$organsess=$this->session->userdata('OrganSess');
		$organizer=$this->Organizer_model->Organizer_details($organizerid,$organsess);
		$general_settings=$this->Web_model->general_settings();

		$params = $this->input->get();
		if(empty($params)){
			$data['status'] = 'error';
			$data['message'] = "No parameters found.";
			$this->session->set_flashdata('message_error', 'We cannot verify your transaction at this moment');
			redirect(base_url('account/result_pins/'));
			
		}
		elseif(isset($params['txref']) && !empty($params['txref']))
		{
			$response = $this->flutterwave_lib->verify_transaction($params['txref']);
			if(!empty($response))
			{
				$response = json_decode($response,1);
				if($response['status'] == 'success' && isset($response['data']['chargecode']) && ( $response['data']['chargecode'] == '00' || $response['data']['chargecode'] == '0') )
				{
				
					$data['txn_id']         = $response['data']['txref'];
					$data['amount']    = $response['data']['amount'];
					
					$refs=$this->security->xss_clean($data['txn_id']);
			        $payments=$this->db->select('*')->from('payments')->where('Payment_Ref',$refs)->where('OrganizerId',$organizerid)->get();//get payments
						
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
				elseif( (isset($params['cancelled']) && $params['cancelled'] == true))
				{
					$data['txn_id']         = $response['data']['txref'];
					$data['amount']    = $response['data']['amount'];
					$data['message'] = 'Payment Cancelled by you or some other reasons. Try again!';
					$data['full_data']      = "No data found";

					$refs=$this->security->xss_clean($data['txn_id']);
			        $payments=$this->db->select('*')->from('payments')->where('Payment_Ref',$refs)->where('OrganizerId',$organizerid)->get();//get payments
			        if ($payments->row()->Payment_Status==1) 
			        {
			        	$this->session->set_flashdata('message_error', "Your Payment had been approved.");
						redirect('account/result_pins');
			        }
			        else
			        {
			        	
			        	$payment_status = array('Payment_Status' => 2);
			        	$update_payment=$this->db->set($payment_status)->where('Payment_Ref',$payments->row()->Payment_Ref)->where('OrganizerId',$organizerid)->update('payments');
			        	if ($update_payment==true) 
			        	{
			        		$this->session->set_flashdata('message_error', "Payment Cancelled by you or some other reasons. Try again!");
							redirect('account/result_pins');
			        	}
			        }
				}
				elseif( $response['status'] == 'error')
				{
					$data['status'] = 'error';
					$data['message'] = $response['message'];
					$data['txn_id']         = $response['data']['txref'];

					$refs=$this->security->xss_clean($data['txn_id']);
			        $payments=$this->db->select('*')->from('payments')->where('Payment_Ref',$refs)->where('OrganizerId',$organizerid)->get();//get payments
			        if ($payments->row()->Payment_Status==1) 
			        {
			        	$this->session->set_flashdata('message_error', "Payment Failed");
						redirect('account/result_pins');
			        }
			        else
			        {
			        	
			        	$payment_status = array('Payment_Status' => 3);
			        	$update_payment=$this->db->set($payment_status)->where('Payment_Ref',$payments->row()->Payment_Ref)->where('OrganizerId',$organizerid)->update('payments');
			        	if ($update_payment==true) 
			        	{
			        		$this->session->set_flashdata('message_error', "Payment Cancelled by you or some other reasons. Try again!");
							redirect('account/result_pins');
			        	}
			        }
				}
			}
			else
			{
				$data['status'] = 'error';
				$data['message'] = "No data returned from ";
				
				$this->session->set_flashdata('message_error', "We could not process your request.");
				redirect('account/result_pins');
			}
		}
	}/* end of payment_status() */
	
	
	/* 
		Flutter wave webhook 
		-------------------------------------------------------------
		You can give this URL in flutter wave dashboard as webhook URL 
		Ex: yourdomain.com/flutterwave/webhook
	*/
    public function webhook(){
        $this->config->load('flutterwave');
        
        $local_secret_hash = $this->config->item('secret_hash');
        
        $body = @file_get_contents("php://input");
        
        $response = json_decode($body,1);
        
		/* 
			to store the flutter wave response and server response into the log file, 
			which can be found under 'application/logs/' folder

			Make a note many times codeIgniter cannot directly read the values of '$_SERVER' variable therefore if such problem arises 
			you can add the following line in your root .htaccess file
			
			SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1 
			
		*/
        log_message('debug', 'Flutter Wave Webhook - Normal Response - JSON DATA --> ' . var_export($response, true));
        log_message('debug', 'Server Variable --> '.var_export($_SERVER,true));
        
		/* Reading the signature sent by flutter wave webhook */
        $signature = (isset($_SERVER['HTTP_VERIF_HASH']))?$_SERVER['HTTP_VERIF_HASH']:'';
        
		/* comparing our local signature with received signature */
        if(empty($signature) || $signature != $local_secret_hash ){
            log_message('error', 'Flutter Wave Webhook - Invalid Signature - JSON DATA --> ' . var_export($response, true));
            log_message('error', 'Server Variable --> '.var_export($_SERVER,true));
            exit();
        }
		
        if(strtolower($response['status']) == 'successful') {
            // TIP: you may still verify the transaction
            // before giving value.
            $response = $this->flutterwave->verify_transaction($response['txRef']);
            
            $response = json_decode($response,1);
            
            if(!empty($response) && isset($response['data']['status']) && strtolower($response['data']['status']) == 'successful' 
                && isset($response['data']['chargecode']) && ( $response['data']['chargecode'] == '00' || $response['data']['chargecode'] == '0')
            ){
                
                $payer_email = $response['data']['custemail'];
                $paymentplan = $response['data']['paymentplan'];
                
                /* 
					Perform Database Operations here 
					Add your custom code here for any other operation like 
					selling good / inserting / update transaction record in database / anything else
				*/
                
            }else{
                /* Transaction failed */
                log_message('error', 'Flutter Wave Webhook - Inner Verification Failed --> ' . var_export($response, true));
                log_message('error', 'Server Variable -->  '.var_export($_SERVER,true));
            }
            
        }else{
            /* Transaction failed */
            log_message('error', 'Flutter Wave Webhook - Outter Verification Failed --> ' . var_export($response, true));
            log_message('error', 'Server Variable -->  '.var_export($_SERVER,true));
        }
        
    }
}
