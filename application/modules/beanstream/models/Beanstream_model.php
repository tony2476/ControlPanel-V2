<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *  This module links in the Beanstream gateway API and structures it for use in the CP.
 *
 * 	This model can be used from any other module in the CP.
 */

class Beanstream_model extends CI_Model {

	private $order_number;
	private $amount;
	private $payment_method;
	private $card_details = array();
	private $billing_address = array();
	public $error;


	function __construct()
	{
		parent::__construct();
		
		// Get Beanstream Config
		$this->load->config('beanstream/config');
		$this->merchant_id = $this->config->item('merchant_id');
		$this->payments_api_key = $this->config->item('payments_api_key');
		$this->api_version = $this->config->item('api_version');
		$this->platform = $this->config->item('platform');
		
		
		//Create Beanstream Gateway
		try 
		{
			$this->beanstream = new \Beanstream\Gateway($this->merchant_id, $this->payments_api_key, $this->platform, $this->api_version);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
	}


	/**
	 *  SETTERS:
	 * 
	 *  We are using setters so that all data can be individually validated and we can keep it private.
	 * 
	 *  No data is passed as parameters to actual gateway functions to improve security.
	 */

	public function set_order_number($order_number)
	{
		$this->order_number = $order_number;
		return (TRUE);
	}

	public function set_amount($amount)
	{
		// ensure amount is a float with 2 decimal places.
		$amount = number_format($amount,2);
		$amount = (float)(string)$amount;
		if (!is_float($amount))
		{
			$this->error = "Amount is not a float";
			return (FALSE);
		}

		$this->amount = $amount;
		return (TRUE);
	}

	public function set_payment_method($payment_method)
	{
		if ($payment_method != 'card' || $payment_method != 'card2')
		{
			$this->error = "Invalid payment method";
			return (FALSE);
		}
		$this->payment_method = $payment_method;
		return (TRUE);
	}

	public function set_card_details($name, $number, $expiry_month, $expiry_year, $cvd)
	{
		$this->card_details['name'] = $name;
		$this->card_details['number'] = $number;
		$this->card_details['expiry_month'] = $expiry_month;
		$this->card_details['expiry_year'] = $expiry_year;
		$this->card_details['cvd'] = $cvd;
	}

	public function set_profile_address($name, $email, $phone, $address_1, $city, $province, $postal_code, $country)
	{
		// Validate address details
		
		// Save address details.
		$this->billing_address['name'] = $name;
		$this->billing_address['email_address'] = $email;
		$this->billing_address['phone_number'] = $phone;
		$this->billing_address['address_line1'] = $address_1;
		$this->billing_address['city'] = $city;
		$this->billing_address['province'] = $province;
		$this->billing_address['postal_code'] = $postal_code;
		$this->billing_address['country'] = $country;
	}

	/*
	 *  END OF SETTERS:
	 */

	/*
	 *  Primary Functions
	 */

	public function create_profile()
	{
		$profile_data = array(
			'billing' => $this->billing_address,
			);

		try
		{
			$profile_id = $this->beanstream->profiles()->createProfile($profile_data);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
		
		return ($profile_id);
	}

	public function get_profile($profile_id)
	{
		try
		{
			$result = $this->beanstream->profiles()->getProfile($profile_id);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
		
		return ($result);
	}

	public function update_profile()
	{
		try
		{
			$result = $this->beanstream->profiles()->updateProfile($profile_id, $profile_data);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
	}

	public function delete_profile($profile_id)
	{
		try
		{
			$result = $this->beanstream->profiles()->deleteProfile($profile_id);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}

		return (TRUE);
	}

	public function add_card_to_profile($profile_id)
	{

		$card_data = array(
			'card' => array(
				'name' => $this->card_details['name'],
				'number' => $this->card_details['number'],
				'expiry_month' => $this->card_details['expiry_month'],
				'expiry_year' => $this->card_details['expiry_year'],
				'cvd' => $this->card_details['cvd']
				)
			);
		try
		{
			$result = $this->beanstream->profiles()->addCard($profile_id, $card_data);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
		return ($result);
	}

	public function take_payment_using_profile($profile_id, $card_id, $order_number, $amount)
	{
		$profile_payment_data = array(
			'order_number' => $order_number, 
			'amount' => $amount
			);
		$complete = 'true';

		try 
		{
			$result = $this->beanstream->payments()->makeProfilePayment($profile_id, $card_id, $profile_payment_data, $complete);
			$transaction_id = $result['id'];

			//complete a profile payment this is only needed for a pre-auth.  We do a complete in the previous call so not needed
			//$result = $this->beanstream->payments()->complete($transaction_id, $profile_payment_data['amount'], $order_number);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
		return ($result);
	}

	public function get_all_cards_in_profile($profile_id)
	{
		//get all cards in profile
		try
		{
			$result = $this->beanstream->profiles()->getCards($profile_id);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
	}

	public function delete_card_from_profile($profile_id, $card_id)
	{
		try
		{
			$result = $this->beanstream->profiles()->deleteCard($profile_id, $card_id);
		}
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}
	}

	public function take_payment()
	{
		//Example Card Payment Data
		$payment_data = array(
			'order_number' => $this->order_number,
			'amount' => $this->amount,
			'payment_method' => $this->payment_method,
			'card' => $this->card_details,
			);
		$complete = TRUE; //set to FALSE for PA

		//Try to submit a Card Payment
		try 
		{

			$result = $this->beanstream->payments()->makeCardPayment($payment_data, $complete);
			return ($result);
			/*
			 * Handle successful transaction, payment method returns
			 * transaction details as result, so $result contains that data
			 * in the form of associative array.
			 */
		} 
		catch (\Beanstream\Exception $e) 
		{
			$this->error = (string) $e->getMessage();
			return (FALSE);
		}

	}
}