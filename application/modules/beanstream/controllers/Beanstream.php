<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Beanstream extends Admin_Controller {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('salesforce/salesforce_model');
		$this->salesforce = New Salesforce_model;
		$this->load->model('beanstream/beanstream_model');
		$this->beanstream = New Beanstream_model;
		
		
	}

	public function index()
	{

	}

	public function test2()
	{
		$order_number = 'orderNumber0024ty';
		$amount = 12.2352;
		$payment_method = 'card';
		$name = 'Mr. Card Testerson';
		$number = '4030000010001234';
		$expiry_month = '07';
		$expiry_year = '22';
		$cvd = '123';

		$this->beanstream->set_order_number($order_number);
		$this->beanstream->set_amount($amount);
		$this->beanstream->set_payment_method($payment_method);
		$this->beanstream->set_card_details($name, $number, $expiry_month, $expiry_year, $cvd);
		$result = $this->beanstream->take_payment();
	}

	public function currency()
	{
		$amount = "12.2" + 0;
		$amount = (float)(string)$amount;
		if (is_float($amount))
		{
			echo "is float";
		}
		echo number_format($amount,2);
	}

	public function create_profile()
	{
		$name = "Karl Gray";
		$email = "karl@test.me.uk";
		$phone = "0121 222 6754";
		$address_1 = "10 nowhere street";
		$city = "London";
		$province = "BC";
		$postal_code = "BC1 H2H";
		$country = "CA";
		$result = $this->beanstream->set_profile_address($name, $email, $phone, $address_1, $city, $province, $postal_code, $country);
		$this->beanstream->create_profile();
	}

	public function delete_profile()
	{
		$profile_id = "4727185573F345C5985F69b95f921361";
		$this->beanstream->delete_profile($profile_id);
	}

		public function get_profile()
	{
		$profile_id = "4727185573F345C5985F69b95f921361";
		if (!$profile = $this->beanstream->get_profile($profile_id))
		{
			echo "Error: " . $this->beanstream->error;
		}
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
			'order_number' => 'orderNumber0021ty',
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