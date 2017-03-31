<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Billing extends Private_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->fullname = $this->user->first_name . " " . $this->user->last_name;
		
	}

	public function index()
	{

	}

	public function details()
	{
		$this->template->set_title("Billing Settings.");
		//$help_data = $this->display_help->display_help();

		//Process cached SF Data
		$this->salesforce->populate_cache($this->user->sf_contact_id);
		$sf_account_data = clone $this->session->userdata('sf_account_cache');
		$sf_contact_data = clone $this->session->userdata('sf_contact_cache');

		if (!is_object($sf_contact_data) || !is_object($sf_account_data))
		{
			$this->session->set_flashdata('error', "We cannot locate any data for this user.");
			redirect('/','refresh');	
		}		

		$form = array 
		(
			'form_open' => form_open('', array('class'=>'form-horizontal')),
			'form_close' => form_close(),
			);
		
		$form = $form + (array) $sf_account_data + (array) $sf_contact_data + $help_data;

		$page_data = $this->parser->parse('billing/billing_settings_form_view', $form, TRUE);

		if (validation_errors())
		{
			$this->session->set_flashdata('message', validation_errors());
		}
		$this->template->set_page_data($page_data);
		$this->template->display_page();

	}

	public function test()
	{
		$merchant_id = '300203582'; 
		$payments_api_key = '9E567BD894E24aF38C47eC614DdDbe23';
		$api_version = 'v1';
		$platform = 'www'; 

		//Create Beanstream Gateway
		$beanstream = new \Beanstream\Gateway($merchant_id, $payments_api_key, $platform, $api_version);

		//Example Card Payment Data
		$payment_data = array(
			'order_number' => 'orderNumber0011ty',
			'amount' => 1.00,
			'payment_method' => 'card',
			'card' => array(
				'name' => 'Mr. Card Testerson',
				'number' => '4030000010001234',
				'expiry_month' => '07',
				'expiry_year' => '22',
				'cvd' => '123'
				)
			);
		$complete = TRUE; //set to FALSE for PA

		//Try to submit a Card Payment
		try 
		{

			$result = $beanstream->payments()->makeCardPayment($payment_data, $complete);
			print_r( $result );
    		/*
    	 	 * Handle successful transaction, payment method returns
    		 * transaction details as result, so $result contains that data
    	 	 * in the form of associative array.
    	 	 */
    	} 
    	catch (\Beanstream\Exception $e) 
    	{
    		echo "<pre>";
    		echo "$e <br />";
    		print_r ($e);
    		echo "</pre>";
    		
    		
    		/*
    		 * Handle transaction error, $e->code can be checked for a
    		 * specific error, e.g. 211 corresponds to transaction being
    		 * DECLINED, 314 - to missing or invalid payment information
    		 * etc.
    		 */
    	}

    }
}